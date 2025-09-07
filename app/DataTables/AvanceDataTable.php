<?php

namespace App\DataTables;

use App\DataTables\BaseDataTable;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Log;
class AvanceDataTable extends BaseDataTable
{

    private $editEmployeePermission;
    private $deleteEmployeePermission;
    private $viewEmployeePermission;

    public function __construct()
    {
        parent::__construct();
        // $this->editEmployeePermission = user()->permission('edit_employees');
        // $this->deleteEmployeePermission = user()->permission('delete_employees');
        // $this->viewEmployeePermission = user()->permission('view_employees');
        // $this->changeEmployeeRolePermission = user()->permission('change_employee_role');
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $roles = Role::where('name', '<>', 'client')->get();
        return datatables()
            ->eloquent($query)
            ->addColumn('check', function ($row) {
                if ($row->id != 1 && $row->id != user()->id) {
                    return '<input type="checkbox" class="select-table-row" id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" onclick="dataTableRowCheck(' . $row->id . ')">';
                }

                return '--';
            })
            ->editColumn('current_role_name', function ($row) {
                $userRole = $row->roles->pluck('name')->toArray();

                if (in_array('admin', $userRole)) {
                    //return __('app.admin');

                } else {
                    //return $row->current_role_name;
                }
            })
           
            ->addColumn('action', function ($row) {

                //$action = '<button class="btn-secondary rounded f-14 p-2 mr-1 edit-row" data-row-id="' . $row->avs_id . '"><i class="fa fa-edit mr-1"></i></button>';

                $action = '<a class="btn-secondary rounded f-14 p-2 mr-1 edit-row" href="' . route('salaireAVS.edit', [$row->avs_id]) . '">
                            <i class="fa fa-edit mr-1"></i>
                        </a>';
                $action .= '<button type="button" class="btn-secondary rounded f-14 p-2 delete-row" data-row-id="' . $row->avs_id . '"><i class="fa fa-trash mr-1"></i></button>';

                return $action;
            })
            ->addColumn('employee_name', function ($row) {
                //return $row->name;
            })
            ->addColumn('montant_avs', function ($row) {
                return strrev(wordwrap(strrev($row->montant_avs), 3, ' ', true));
            })
            ->addColumn('rembourse_avs', function ($row) {
                return strrev(wordwrap(strrev($row->rembourse_avs), 3, ' ', true));
            })
            ->addColumn('reste_avs', function ($row) {
                return strrev(wordwrap(strrev($row->reste_avs), 3, ' ', true));
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->editColumn(
                'status',
                function ($row) {
                    if ($row->status == 'active') {
                        return ' <i class="fa fa-circle mr-1 text-light-green f-10"></i>' . __('app.active');
                    }
                    else {
                        return '<i class="fa fa-circle mr-1 text-red f-10"></i>' . __('app.inactive');
                    }
                }
            )
            ->editColumn('name', function ($row) {
                return view('components.employee', [
                    'user' => $row
                ]);
            })
            ->addIndexColumn()
            ->setRowId(function ($row) {
                return 'row-' . $row->id;
            })
            ->rawColumns(['name', 'action', 'role', 'status', 'check'])
            ->removeColumn('roleId')
            ->removeColumn('roleName')
            ->removeColumn('current_role');
    }

    /**
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $request = $this->request();

        $userRoles = '';

        if ($request->role != 'all' && $request->role != '') {
            $userRoles = Role::findOrFail($request->role);
        }

        $users = $model->with('role', 'roles', 'employeeDetail', 'session')
            ->withoutGlobalScope('active')
            ->join('salaire_avances', 'salaire_avances.user_id', '=', 'users.id')
            ->select('rembourse_avs', 'montant_avs', 'reste_avs', 'users.name', 'users.lastname', DB::raw('DATE_FORMAT(date_avs, "%d-%m-%Y") as dateAVS'),'users.image', 'users.id as id', 'salaire_avances.id as avs_id', 'motif_avs')
            ->orderBy('users.name')
            ->orderBy('users.lastname');
            
            
            


        

        if ($request->employee != 'all' && $request->employee != '') {
            $users = $users->where('users.id', $request->employee);
        }

        


        if ($request->searchText != '') {
            $users = $users->where(function ($query) {
                $query->where('users.name', 'like', '%' . request('searchText') . '%')
                    ->orWhere('users.lastname', 'like', '%' . request('searchText') . '%')
                    ->orWhere('salaire_avances.motif_avs', 'like', '%' . request('searchText') . '%');
            });
        }

        return $users;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employees-table')
            ->columns($this->getColumns())
            ->minifiedAjax()

            ->destroy(true)
            ->orderBy(2)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->dom($this->domHtml)

            ->language(__('app.datatable'))
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["employees-table"].buttons().container()
                     .appendTo( "#table-actions")
                 }',
                'fnDrawCallback' => 'function( oSettings ) {
                   //
                   $(".select-picker").selectpicker();
                 }',
            ])
            /*->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> ' . trans('app.exportExcel')]))*/;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'check' => [
                'title' => '<input type="checkbox" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                'exportable' => false,
                'orderable' => false,
                'searchable' => false
            ],

            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => false],
            __('app.name') => ['data' => 'name', 'name' => 'name', 'exportable' => false, 'title' => __('app.name')],
            __('app.lastname') => ['data' => 'lastname', 'lastname' => 'lastname', 'exportable' => false, 'title' => __('app.lastname')],
            'Motif' => ['data' => 'motif_avs', 'name' => 'motif_avs', 'title' => 'Motif'],
            'Montant emprunté' => ['data' => 'montant_avs', 'name' => 'montant_avs', 'title' => 'Montant emprunté'],
            'Montant remboursé' => ['data' => 'rembourse_avs', 'name' => 'rembourse_avs', 'title' => 'Montant remboursé'],
            'Reste à remboursé' => ['data' => 'reste_avs', 'name' => 'reste_avs', 'title' => 'Reste à remboursé'],
            Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    public function filename(): string
    {
        return 'employees_' . date('YmdHis');
    }

    public function pdf()
    {
        set_time_limit(0);

        if ('snappy' == config('datatables-buttons.pdf_generator', 'snappy')) {
            return $this->snappyPdf();
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('datatables::print', ['data' => $this->getDataForPrint()]);

        return $pdf->download($this->getFilename() . '.pdf');
    }

}
