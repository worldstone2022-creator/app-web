<?php

namespace App\Http\Controllers;

use App\DataTables\TimeLogReportDataTable;
use App\DataTables\TimeLogConsolidatedReportDataTable;
use App\DataTables\TimeLogProjectwiseReportDataTable;
use App\Exports\ProjectwiseTimeLogExport;
use App\Helper\Reply;
use App\Models\Project;
use App\Models\ProjectTimeLog;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TimelogReportController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.timeLogReport';
        $this->pageIcon = 'ti-pie-chart';
    }

    public function index(TimeLogReportDataTable $dataTable)
    {
        if (!request()->ajax()) {
            $this->fromDate = now($this->company->timezone)->startOfMonth();
            $this->toDate = now($this->company->timezone);

            $this->employees = User::allEmployees();
            $this->clients = User::allClients();
            $this->projects = Project::allProjects();
            $this->tasks = Task::all();
        }

        return $dataTable->render('reports.timelogs.index', $this->data);
    }

    public function timelogChartData(Request $request)
    {
        $projectId = $request->projectId;
        $employee = $request->employee;
        $client = $request->client;
        $taskId = $request->taskId;
        $approved = $request->approved;
        $invoice = $request->invoice;

        $earliestLog = ProjectTimeLog::orderBy('start_time', 'asc')->first();
        $latestLog = ProjectTimeLog::orderBy('end_time', 'desc')->first();

        // $startDate = $earliestLog ? $earliestLog->start_time->toDateString() : now($this->company->timezone)->startOfMonth()->toDateString();
        // $endDate = $latestLog ? $latestLog->end_time->toDateString() : now($this->company->timezone)->toDateString();
        $startDate = now($this->company->timezone)->startOfMonth()->toDateString();
        $endDate = now($this->company->timezone)->endOfMonth()->toDateString();

        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = companyToDateString($request->startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = companyToDateString($request->endDate);
        }

        $timelogs = ProjectTimeLog::with('breaks', 'activeBreak')
            ->whereDate('project_time_logs.start_time', '>=', $startDate)
            ->whereDate('project_time_logs.end_time', '<=', $endDate)
            ->whereHas('task', function ($query) {
                $query->whereNull('deleted_at');
            });

        if (!is_null($employee) && $employee !== 'all') {
            $timelogs = $timelogs->where('project_time_logs.user_id', $employee);
        }

        if (!is_null($client) && $client !== 'all') {
            $timelogs = $timelogs->where('projects.client_id', $client);
        }

        if (!is_null($projectId) && $projectId !== 'all') {
            $timelogs = $timelogs->where('project_time_logs.project_id', '=', $projectId);
        }

        if (!is_null($taskId) && $taskId !== 'all') {
            $timelogs = $timelogs->where('project_time_logs.task_id', '=', $taskId);
        }

        if (!is_null($approved) && $approved !== 'all') {
            if ($approved == 2) {
                $timelogs = $timelogs->whereNull('project_time_logs.end_time');
            }
            else {
                $timelogs = $timelogs->where('project_time_logs.approved', '=', $approved);
            }
        }

        if (!is_null($invoice) && $invoice !== 'all') {
            if ($invoice == 0) {
                $timelogs = $timelogs->where('project_time_logs.invoice_id', '=', null);

            }else if ($invoice == 1) {
                $timelogs = $timelogs->where('project_time_logs.invoice_id', '!=', null);
            }
        }

        $total_break_hours = 0;

        foreach ($timelogs->get() as $timelog) {
            $total_break_hours += $timelog->breaks->sum('total_minutes');
        }

        $timelogg = $timelogs
        ->groupBy(DB::raw('DATE(project_time_logs.start_time)'))
        ->orderBy('start_time', 'ASC')
        ->get([
            DB::raw('DATE_FORMAT(start_time,\'%d-%M-%y\') as date'),
            DB::raw('FLOOR(SUM(total_minutes)) as total_minutes'),
        ]);

        $breaks = ProjectTimeLog::with('breaks')
            ->whereDate('project_time_logs.start_time', '>=', $startDate)
            ->whereDate('project_time_logs.end_time', '<=', $endDate)
            ->get()
            ->groupBy(fn ($log) => $log->start_time->format('d-F-y'))
            ->map(function ($logs) {
                return $logs->sum(fn ($log) => $log->breaks->sum('total_minutes'));
            });

        $values = [];

        foreach ($timelogg as $log) {
            $breakMinutes = $breaks[$log->date] ?? 0;
            $loggedHours = $log->total_minutes - $breakMinutes;
            $hours = intdiv($loggedHours, 60);
            $minutes = $loggedHours % 60;
            // $minutes = $minutes > 0 ? $minutes : 0;
            // Format output based on hours and minutes
            
            $values[] = $hours > 0
                ? $hours  . ($minutes > 0 ? '.' . $minutes : '')
                : ($minutes > 0 ? $minutes : 0);
        }

        $data['labels'] = $timelogg->pluck('date')->toArray();
        $data['values'] = $values;
        $data['colors'] = [$this->appTheme->header_color];
        $data['name'] = __('modules.dashboard.totalHoursLogged');

        $this->chartData = $data;
        $html = view('reports.timelogs.chart', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
    }

    public function consolidateIndex(TimeLogConsolidatedReportDataTable $dataTable)
    {
        $this->pageTitle = 'app.timelogConsolidatedReport';

        if (!request()->ajax()) {
            $this->fromDate = now($this->company->timezone)->startOfMonth();
            $this->toDate = now($this->company->timezone);

            $this->employees = User::allEmployees();
            $this->clients = User::allClients();
            $this->projects = Project::allProjects();
            $this->tasks = Task::all();
        }

        return $dataTable->render('reports.timelogs.consolidate-index', $this->data);
    }

    public function totalTime(Request $request)
    {
        $startDate = ($request->startDate == null) ? null : now($this->company->timezone)->startOfMonth()->toDateString();
        $endDate = ($request->endDate == null) ? null : now($this->company->timezone)->toDateString();

        $projectTimeLog = ProjectTimeLog::with('breaks')
            ->whereHas('task', function ($query) {
                $query->whereNull('deleted_at');
            })->where('user_id', $request->employeeID);

        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = companyToDateString($request->startDate);
            $projectTimeLog = $projectTimeLog->where(DB::raw('DATE(`start_time`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = companyToDateString($request->endDate);
            $projectTimeLog = $projectTimeLog->where(DB::raw('DATE(`start_time`)'), '<=', $endDate);
        }

        if ($request->employeeID != 'all' && !is_null($request->employeeID)) {
            $employeeID = $request->employeeID;
            $projectTimeLog = $projectTimeLog->where(function ($query) use ($employeeID) {
                $query->where('user_id', $employeeID);
            });
        }

        $projectTimeLog = $projectTimeLog->get();

        $totalWorkingTime = 0;
        $totalBreakTime = 0;

        foreach ($projectTimeLog as $projectTime) {
            if (is_null($projectTime->end_time)) {
                $totalWorkingTime += (($projectTime->activeBreak) ? $projectTime->activeBreak->start_time->diffInMinutes($projectTime->start_time) : now()->diffInMinutes($projectTime->start_time)) - $projectTime->breaks->sum('total_minutes');
            }
            else {
                $totalWorkingTime += $projectTime->total_minutes - $projectTime->breaks->sum('total_minutes');
            }
            $totalBreakTime += $projectTime->breaks->sum('total_minutes');
        }

        $totalHoursWorked = $this->formatTime($totalWorkingTime);
        $totalBreak = $this->formatTime($totalBreakTime);
        $totalEarnings = $projectTimeLog->sum('earnings');

        return Reply::dataOnly(['status' => 'success', 'totalHoursWorked' => $totalHoursWorked, 'totalBreak' => $totalBreak, 'totalEarnings' => currency_format($totalEarnings, company()->currency_id)]);

    }

    private function formatTime($totalMinutes)
    {
        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return $hours > 0
            ? $hours . 'h' . ($minutes > 0 ? ' ' . sprintf('%02dm', $minutes) : '')
            : ($minutes > 0 ? sprintf('%dm', $minutes) : '0s');
    }

    public function projectWiseTimelog(TimeLogProjectwiseReportDataTable $dataTable)
    {
        $this->pageTitle = 'app.projectWiseTimeLogReport';

        if (!request()->ajax()) {
            $this->fromDate = now($this->company->timezone)->startOfMonth();
            $this->toDate = now($this->company->timezone);

            $this->projects = Project::allProjects();
            $this->employees = User::allEmployees();
        }

        return $dataTable->render('reports.timelogs.project-wise', $this->data);
    }

    public function exportProjectWiseTimeLog(Request $request)
    {
        if ($request->startDate == null || $request->startDate == 'null') {
            $startDate = null;
        }
        else {
            $startDate = companyToDateString($request->startDate);
        }


        if ($request->end == null || $request->end == 'null') {
            $endDate = null;
        }
        else {
            $endDate = companyToDateString($request->startDate);
        }

        $employeeId = $request->employee;
        $projectId = $request->project;

        $export = new ProjectwiseTimeLogExport(
            $startDate,
            $endDate,
            $employeeId, $projectId
        );

        return Excel::download($export, 'project-wise-timelog.xlsx');
    }

}
