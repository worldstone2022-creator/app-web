<?php

namespace App\Http\Controllers;

use App\DataTables\AnnualLeaveDataTable;
use App\Helper\Reply;
use PDF;
use App\Http\Requests\Leaves\ActionLeave;
use App\Http\Requests\StoreAnnualLeave;
use App\Http\Requests\UpdateAnnualLeave;
use App\Models\Designation;
use App\Models\employee_activite;
use App\Models\EmployeeLeaveQuota;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\annualLeave;
use App\Models\niveau_etude;
use App\Models\User;
use App\Models\EmployeeDetails;
use App\Models\salaire_bulletin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\TwiML\Voice\Reject;

class annualLeaveController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.annualLeave';
        $this->middleware(function ($request, $next) {
            abort_403(!in_array('leaves', $this->user->modules));
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AnnualLeaveDataTable $dataTable)
    {
        $viewPermission = user()->permission('view_leave');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));
        $this->employees = User::allEmployees(null, null, ($viewPermission == 'all' ? 'all' : null));
        //$this->leaveTypes = LeaveType::all();

        return $dataTable->render('annual-leaves.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->addPermission = user()->permission('add_leave');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $this->employees = User::allEmployees();
        if ($this->addPermission == 'added') {
            $this->defaultAssign = User::with('leaveTypes', 'leaveTypes.leaveType')->findOrFail(user()->id);
            $this->leaveQuotas = $this->defaultAssign->leaveTypes;

        } else if (isset(request()->default_assign)) {
            $this->defaultAssign = User::with('leaveTypes', 'leaveTypes.leaveType')->findOrFail(request()->default_assign);
            $this->leaveQuotas = $this->defaultAssign->leaveTypes;

        } else {
            $this->leaveTypes = LeaveType::all();
        }

        //dd($this->defaultAssign);

        if (request()->ajax()) {
            $this->pageTitle = 'Attribuer un congés annuel';
            $html = view('annual-leaves.ajax.create', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->view = 'annual-leaves.ajax.create';

        return view('annual-leaves.create', $this->data);
    }

    /**
     * @param StoreLeave $request
     * @return array|void
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function store(StoreAnnualLeave $request)
    {
        $this->addPermission = user()->permission('add_leave');
        abort_403(!in_array($this->addPermission, ['all', 'added']));

        $redirectUrl = urldecode($request->redirect_url);

        if ($redirectUrl == '') {
            $redirectUrl = route('annualLeave.index');
        }


            $leave = new annualLeave();

            $leave->user_id = $request->user_id;
            $leave->nbre_jour_conge = $request->nbre_jour_conge;
            $leave->nbre_jour_restant =$request->nbre_jour_conges_dus - $request->nbre_jour_conge;
            $leave->leave_date_debut = Carbon::createFromFormat($this->global->date_format, $request->leave_date_debut)->format('Y-m-d');
            $leave->leave_date_fin = Carbon::createFromFormat($this->global->date_format, $request->leave_date_fin)->format('Y-m-d');
            $leave->description = $request->description;
            $leave->status = $request->status;
            $leave->save();
            if ($request->status=="approved") {
                $employee = EmployeeDetails::where('user_id', '=', $request->user_id)->first();
                $this->calculateLeaveAllocation($request->user_id, $request->nbre_jour_conge, $leave->id);
                
                if ($employee) {
                    $employee->nbre_jour_conges_dus = $request->nbre_jour_conges_dus - $request->nbre_jour_conge;
                    $employee->nbre_jour_conges_pris = $employee->nbre_jour_conges_pris + $request->nbre_jour_conge;

                    $employee->save();
                }
            }

            return Reply::successWithData('congés planifié avec succès', ['redirectUrl' => $redirectUrl]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $this->annualLeave = annualLeave::findOrFail($id);
        //dd($this->annualLeave );
        $this->viewPermission = user()->permission('view_leave');
        /*abort_403(!($this->viewPermission == 'all'
            || ($this->viewPermission == 'added' && user()->id == $this->leave->added_by)
            || ($this->viewPermission == 'owned' && user()->id == $this->leave->user_id)
            || ($this->viewPermission == 'both' && (user()->id == $this->leave->user_id || user()->id == $this->leave->added_by))
        ));*/

        $this->pageTitle = $this->annualLeave->user->name.' '.$this->annualLeave->user->lastname;

        if (request()->ajax()) {
            $html = view('annual-leaves.ajax.show', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->view = 'annual-leaves.ajax.show';

        return view('annual-leaves.create', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function employeeCheck($userId)
    
    {
        if ($userId != "") {
            $employee = User::join('employee_details', 'employee_details.user_id', '=', 'users.id')->findOrFail($userId);
            return Reply::dataOnly(['status' => 'success', 'data' => $employee]);
        }

    }
    public function edit($id)
    {
        $this->annuaLleave = annuaLleave::findOrFail($id);
        $this->editPermission = user()->permission('edit_leave');
        abort_403(!(
            ($this->editPermission == 'all'
                || ($this->editPermission == 'added' && $this->annuaLleave->added_by == user()->id)
                || ($this->editPermission == 'owned' && $this->annuaLleave->user_id == user()->id)
                || ($this->editPermission == 'both' && ($this->annuaLleave->user_id == user()->id || $this->leave->added_by == user()->id))
            )
            && ($this->annuaLleave->status == 'pending')));

        $this->employees = User::allEmployees();

        $this->pageTitle = $this->annuaLleave->user->name.' '.$this->annuaLleave->user->lastname;

        if ($this->editPermission == 'added') {
            $this->defaultAssign = user();

        } else if (isset(request()->default_assign)) {
            $this->defaultAssign = User::findOrFail(request()->default_assign);
        }

        if (request()->ajax()) {
            $html = view('annual-leaves.ajax.edit', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->view = 'annual-leaves.ajax.edit';

        return view('annual-leaves.create', $this->data);
    }

    /**
     * @param UpdateLeave $request
     * @param int $id
     * @return array|void
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function update(UpdateAnnualLeave $request, $id)
    {
        $leave = annualLeave::findOrFail($id);
        $this->editPermission = user()->permission('edit_leave');

        abort_403(!($this->editPermission == 'all'
            || ($this->editPermission == 'added' && $leave->added_by == user()->id)
            || ($this->editPermission == 'owned' && $leave->user_id == user()->id)
            || ($this->editPermission == 'both' && ($leave->user_id == user()->id || $leave->added_by == user()->id))
        ));
        
        $leave->user_id = $request->user_id;
        $leave->nbre_jour_conge = $request->nbre_jour_conge;
        $leave->nbre_jour_restant =$request->nbre_jour_conges_dus + $request->jrs_ant_attr - $request->nbre_jour_conge;
        $leave->leave_date_debut = Carbon::createFromFormat($this->global->date_format, $request->leave_date_debut)->format('Y-m-d');
        $leave->leave_date_fin = Carbon::createFromFormat($this->global->date_format, $request->leave_date_fin)->format('Y-m-d');
        $leave->description = $request->description;
        $leave->status = $request->status;
        $leave->save();
        
        if ($request->has('reject_reason')) {
            $leave->reject_reason = $request->reject_reason;
        }

        if ($request->has('status')) {
            $leave->status = $request->status;
        }
        if ($request->status=="approved") {
            $employee = EmployeeDetails::where('user_id', '=', $request->user_id)->first();
            $this->calculateLeaveAllocation($request->user_id, $request->nbre_jour_conge, $leave->id);

            if ($employee) {
                $employee->nbre_jour_conges_dus = $request->nbre_jour_conges_dus - $request->nbre_jour_conge;
                $employee->nbre_jour_conges_pris = $employee->nbre_jour_conges_pris + $request->nbre_jour_conge;
                $employee->save();
            }
        }

        $leave->save();

        return Reply::successWithData(('messages.leaveAssignSuccess'), ['redirectUrl' => route('annualLeave.index')]);
    }

    public function calculateLeaveAllocation($employeeId, $acquiredLeaveDays, $leaveId)
    {
        // Récupérer l'employé
        $employee = EmployeeDetails::where('user_id', $employeeId)->first();

        //$employee = Employee::findOrFail($employeeId);

        // Récupérer la date d'embauche
        $dateOfHire = $employee->joining_date;

        // Calculer le cumul des salaires bruts
        $cumulativeSalaries = salaire_bulletin::where('user_id', $employeeId)
            ->where('salaire_fin', '>=', $dateOfHire)
            ->sum('total_brut');

        // Calculer le cumul des jours de présence

        $cumulativePresenceDays = salaire_bulletin::where('user_id', $employeeId)
            //->where('salaire_fin', '>=', $dateOfHire)
            ->sum('nbreJour');


        // Calculer le montant brut de l'allocation de congés
        if ($cumulativePresenceDays > 0) {
            $leaveAllowance = $cumulativeSalaries / $cumulativePresenceDays * $acquiredLeaveDays;
        } else {
            $leaveAllowance = 0; // pour éviter la division par zéro
        }

        $leave = annualLeave::findOrFail($leaveId);
        $leave->allocation = $leaveAllowance;
        $leave->save();
        return $leaveAllowance;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = annualLeave::findOrFail($id);
        $this->deletePermission = user()->permission('delete_leave');

        abort_403(!($this->deletePermission == 'all'
            || ($this->deletePermission == 'added' && $leave->added_by == user()->id)
            || ($this->deletePermission == 'owned' && $leave->user_id == user()->id)
            || ($this->deletePermission == 'both' && ($leave->user_id == user()->id || $leave->added_by == user()->id))
        ));

        annualLeave::destroy($id);
        return Reply::successWithData('Demande de congés supprimée avec succès', ['redirectUrl' => route('annualLeave.index')]);
    }

    public function leaveCalendar(Request $request)
    {
        $viewPermission = user()->permission('view_leave');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));

        $this->pendingLeaves = Leave::where('status', 'pending')->count();
        $this->employees = User::allEmployees();
        $this->leaveTypes = LeaveType::all();
        $this->pageTitle = 'app.menu.calendar';

        if (request('start') && request('end')) {

            $leaveArray = array();

            $leavesList = Leave::join('users', 'users.id', 'leaves.user_id')
                ->join('leave_types', 'leave_types.id', 'leaves.leave_type_id')
                ->where('users.status', 'active')
                ->where('leaves.status', '<>', 'rejected')
                ->select('leaves.id', 'users.name', 'leaves.leave_date', 'leaves.status', 'leave_types.type_name', 'leave_types.color', 'leaves.leave_date', 'leaves.duration', 'leaves.status');

            if (!is_null($request->startDate)) {
                $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
                $leavesList->whereRaw('Date(leaves.leave_date) >= ?', [$startDate]);
            }

            if (!is_null($request->endDate)) {
                $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();

                $leavesList->whereRaw('Date(leaves.leave_date) <= ?', [$endDate]);
            }

            if ($request->employeeId != 'all' && $request->employeeId != '') {
                $leavesList->where('users.id', $request->employeeId);
            }

            if ($request->leaveTypeId != 'all' && $request->leaveTypeId != '') {
                $leavesList->where('leave_types.id', $request->leaveTypeId);
            }

            if ($request->status != 'all' && $request->status != '') {
                $leavesList->where('leaves.status', $request->status);
            }

            if ($request->searchText != '') {
                $leavesList->where('users.name', 'like', '%' . $request->searchText . '%');
            }

            if ($viewPermission == 'owned') {
                $leavesList->where('leaves.user_id', '=', user()->id);
            }

            if ($viewPermission == 'added') {
                $leavesList->where('leaves.added_by', '=', user()->id);
            }

            if ($viewPermission == 'both') {
                $leavesList->where(function ($q) {
                    $q->where('leaves.user_id', '=', user()->id);;

                    $q->orWhere('leaves.added_by', '=', user()->id);;
                });
            }


            $leaves = $leavesList->get();

            foreach ($leaves as $key => $leave) {
                /** @phpstan-ignore-next-line */
                $title = ucfirst($leave->name);

                $leaveArray[] = [
                    'id' => $leave->id,
                    'title' => $title,
                    'start' => $leave->leave_date->format('Y-m-d'),
                    'end' => $leave->leave_date->format('Y-m-d'),
                    /** @phpstan-ignore-next-line */
                    'color' => $leave->color
                ];
            }

            return $leaveArray;
        }

        return view('leaves.calendar.index', $this->data);
    }

    public function applyQuickAction(Request $request)
    {
        switch ($request->action_type) {
        case 'delete':
            $this->deleteRecords($request);
                return Reply::success(__('messages.deleteSuccess'));
        case 'change-leave-status':
            $this->changeBulkStatus($request);
                return Reply::success(__('messages.statusUpdatedSuccessfully'));
        default:
                return Reply::error(__('messages.selectAction'));
        }
    }

    protected function deleteRecords($request)
    {
        abort_403(user()->permission('delete_leave') != 'all');

        Leave::whereIn('id', explode(',', $request->row_ids))->delete();
    }

    protected function changeBulkStatus($request)
    {
        abort_403(user()->permission('edit_leave') != 'all');

        annualLeave::whereIn('id', explode(',', $request->row_ids))->update(['status' => $request->status]);
    }

    public function leaveAction(Request $request)
    {
        abort_403(user()->permission('approve_or_reject_leaves') == 'none' && user()->id != $request->id_superieur);

        $leave = annualLeave::findOrFail($request->leaveId);
        if(user()->id == $request->id_superieur){
            $leave->avis_superieur_hierarchique=$request->action;
            $leave->date_avis_superieur=new \DateTime();
            if (isset($request->reason)) {
                $leave->superieur_reject_reason = $request->reason;
            }
        }else{
            $leave->status = $request->action;
            $leave->date_avis_direction=new \DateTime();
            $leave->admin_id=user()->id;
            if (isset($request->reason)) {
                $leave->reject_reason = $request->reason;
            }
        }

        $leave->save();

        if ($leave) {
            if ($request->action=="approved" && user()->id != $request->id_superieur) {
                
                $employee = EmployeeDetails::where('user_id', '=', $leave->user_id)->first();
                $this->calculateLeaveAllocation($leave->user_id, $leave->nbre_jour_conge, $leave->id);

                if ($employee) {
                    $employee->nbre_jour_conges_dus -= $leave->nbre_jour_conge;
                    $employee->nbre_jour_conges_pris += $leave->nbre_jour_conge;
                    $employee->save();


                }
            }
        }

        return Reply::success(__('messages.leaveStatusUpdate'));

    }

    public function rejectLeave(Request $request)
    {
        abort_403(user()->permission('approve_or_reject_leaves') == 'none'&& user()->id==$request->id_superieur);

        $this->leaveAction = $request->leave_action;
        $this->leaveID = $request->leave_id;
        $this->id_superieur=$request->id_superieur;

        return view('annual-leaves.reject.index', $this->data);
    }

    public function personalLeaves()
    {
        $this->pageTitle = __('modules.leaves.myLeaves');

        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes', 'leaveTypes.leaveType', 'country', 'employee'])
            ->withoutGlobalScope('active')
            ->withCount('member', 'agents', 'tasks')
            ->findOrFail(user()->id);

        $this->leaveTypes = LeaveType::byUser(user()->id);
        $this->leavesTakenByUser = Leave::byUserCount(user()->id);
        $this->allowedLeaves = $this->employee->leaveTypes->sum('no_of_leaves');
        $this->employeeLeavesQuota = $this->employee->leaveTypes;
        $this->employeeLeavesQuotas = $this->employee->leaveTypes;
        $this->view = 'leaves.ajax.personal';

        return view('leaves.create', $this->data);
    }

    public function getAnnualLeaveDetails($leave)
{
    // Initialisation des variables
    $totalWorkDays = 0; // Nombre de jours ouvrables
    $totalCalendarDays = 0; // Nombre de jours calendaires
    $leaveStartDate = null; // Date de début des congés
    $leaveEndDate = null; // Date de fin des congés

    // Vérification de l'existence des dates de début et de fin
    if ($leave->leave_date_debut && $leave->leave_date_fin) {
        $startDate = \Carbon\Carbon::parse($leave->leave_date_debut);
        $endDate = \Carbon\Carbon::parse($leave->leave_date_fin);

        // Calcul des jours calendaires (inclusif)
        $daysCalendar = $startDate->diffInDays($endDate) + 1; // Ajouter 1 pour inclure les deux dates
        $totalCalendarDays += $daysCalendar;

        // Calcul des jours ouvrables en utilisant la fonction getBusinessDays
        $totalWorkDays = $this->getBusinessDays($startDate, $endDate);
    }

    // Si le congé est approuvé, définir les dates de début et de fin
    if ($leave->status === 'approved') {
        $leaveStartDate = $leave->leave_date_debut;
        $leaveEndDate = $leave->leave_date_fin;
    }

    // Calculer la date de reprise du service (un jour après la fin des congés)
    $returnDate = $leaveEndDate ? \Carbon\Carbon::parse($leaveEndDate)->addDay()->toDateString() : null;

    // Structurer les données pour le retour
    return [
        'total_work_days' => $totalWorkDays, // Nombre total de jours ouvrables
        'total_calendar_days' => $totalCalendarDays, // Nombre total de jours calendaires
        'leave_start_date' => $leaveStartDate, // Date de début des congés
        'leave_end_date' => $leaveEndDate, // Date de fin des congés
        'return_to_service_date' => $returnDate, // Date de reprise du service
    ];
}

    public function getBusinessDays(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate, $holidays = [])
    {
        $businessDays = 0;

        // Itération sur chaque jour entre les deux dates incluses
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Vérifier si c'est un jour ouvrable (pas un week-end ni un jour férié)
            if (!$date->isWeekend() && !in_array($date->toDateString(), $holidays)) {
                $businessDays++;
            }
        }

        return $businessDays;
    }


    public function downloadAnnualLeaveFiche($id)
    {
        $this->annualLeave = annualLeave::withoutGlobalScope('active')->with(['user.employeeDetail'])->findOrFail($id);

        $this->editPermission = user()->permission('edit_employees');

        abort_403(!($this->editPermission == 'all'
        || ($this->editPermission == 'added' && $this->employee->employeeDetail->added_by == user()->id)
        || ($this->editPermission == 'owned' && $this->employee->id == user()->id)
        || ($this->editPermission == 'both' && ($this->employee->id == user()->id || $this->employee->employeeDetail->added_by == user()->id))
        ));
        $this->employee=$this->annualLeave->user;
        $this->lastLeave=AnnualLeave::withoutGlobalScope('active')
        ->where('user_id', $this->annualLeave->user_id) 
        ->where('leave_date_fin', '<', $this->annualLeave->leave_date_debut) 
        ->orderBy('leave_date_fin', 'desc') 
        ->first();
        $this->annualLeaveDetails = $this->getAnnualLeaveDetails($this->annualLeave);
        $employeeDetail=$this->annualLeave->user->employeeDetail;
        $this->pageTitle = "télécharger fiche de demande de congés annuels";

        $this->designations = Designation::where('id', $employeeDetail->designation_id)->first();
        $this->teams=$this->employee->employeeDetail->department;

        $this->superieurs = User::where('id', $employeeDetail->id_superieur)->first();
        $this->admin = User::where('id', $this->annualLeave->admin_id)->first();


        if (!is_null($this->employee->employeeDetail)) {
            $this->employeeDetail = $this->employee->employeeDetail->withCustomFields();

            if (!empty($this->employeeDetail->getCustomFieldGroupsWithFields())) {
                $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
            }
        }
            $data = [
                'title' => 'Fiche demande de congé Annuel',
                'logo'  => parse_url(global_setting()->logo_url, PHP_URL_PATH),
                'infos' => $this->data,
                
            ];
            $fileName = 'fiche-demande-de-congés' . $id . '-' . date('mdYHis');

            return PDF::loadView('annual-leaves.ajax.fiche-demande-conge-download', compact('data'))
                ->setPaper('a4')
                ->setWarnings(false)
                ->stream($fileName . '.pdf');


    }

}

