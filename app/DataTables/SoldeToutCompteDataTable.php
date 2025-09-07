<?php

namespace App\DataTables;

use App\DataTables\BaseDataTable;
use App\Models\Role;
use App\Models\User;
use App\Models\solde_tout_compte;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class SoldeToutCompteDataTable extends BaseDataTable
{

    private $editEmployeePermission;
    private $deleteEmployeePermission;
    private $viewEmployeePermission;

    public function __construct()
    {
        parent::__construct();
        $this->editEmployeePermission = user()->permission('edit_employees');
        $this->deleteEmployeePermission = user()->permission('delete_employees');
        $this->viewEmployeePermission = user()->permission('view_employees');
        $this->changeEmployeeRolePermission = user()->permission('change_employee_role');
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="select-table-row" id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" onclick="dataTableRowCheck(' . $row->id . ')">';
            })
            ->addColumn('employee_name', function ($row) {
                return $row->user->name.' '.$row->user->lastname;
            })
            ->editColumn('employee', function ($row) {
                return view('components.employee', [
                    'user' => $row->user
                ]);
            })
            ->addColumn('fin_contrat', function ($row) {
                return Carbon::parse($row->user->employeeDetail->date_end_contrat)->format($this->global->date_format);
            })
            ->addColumn('gratification', function ($row) {
                return strrev(wordwrap(strrev($row->gratification), 3, ' ', true));
            })
            ->addColumn('indemnite_conge', function ($row) {
                return strrev(wordwrap(strrev($row->indemnite_conge), 3, ' ', true));
            })
            ->addColumn('salaire_net_du_mois', function ($row) {
                return strrev(wordwrap(strrev($row->salaire_net_du_mois), 3, ' ', true));
            })
            ->addColumn('indemnite_licenciement', function ($row) {
                return strrev(wordwrap(strrev($row->indemnite_licenciement), 3, ' ', true));
            })
            ->addColumn('salaire_preavis', function ($row) {
                return strrev(wordwrap(strrev($row->salaire_preavis), 3, ' ', true));
            })
            ->addColumn('indemnite_de_fin_de_contrat', function ($row) {
                return strrev(wordwrap(strrev($row->indemnite_de_fin_de_contrat), 3, ' ', true));
            })
            ->addColumn('solde_tout_compte', function ($row) {
                return strrev(wordwrap(strrev($row->solde_tout_compte), 3, ' ', true));
            })
            
            ->addColumn('type', function ($row) {
                if ($row->motif_end_contrat == 'fin_contrat') {
                    $type = 'Contrat échu';
                }
                else if ($row->motif_end_contrat == 'demission') {
                    $type = 'Démission';
                }
                else if ($row->motif_end_contrat == 'licenciement'){
                    $type = 'Licenciement';
                }

                return  $type;
            })
            
            ->addColumn('action', function ($row) {

                /*$actions = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link" id="dropdownMenuLink-41" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-41" tabindex="0" x-placement="bottom-end" style="position: absolute; transform: translate3d(-137px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">';

                    $actions .= '<a href="' . route('annualLeave.show', [$row->id]) . '" class="dropdown-item openRightModal"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';

                if ($row->status == 'pending' && $this->approveRejectPermission == 'all') {
                    $actions .= '<a class="dropdown-item leave-action" data-leave-id=' . $row->id . '
                             data-leave-action="approved" data-user-id="' . $row->user_id . 'href="javascript:;">
                                <i class="fa fa-check mr-2"></i>
                                ' . __('app.approve') . '
                        </a>
                        <a data-leave-id=' . $row->id . '
                             data-leave-action="rejected" data-user-id="' . $row->user_id . '" class="dropdown-item leave-action-reject" href="javascript:;">
                               <i class="fa fa-times mr-2"></i>
                                ' . __('app.reject') . '
                        </a>';
                }

                if ($row->status == 'pending') {
                    if ($this->editLeavePermission == 'all'
                    || ($this->editLeavePermission == 'added' && user()->id == $row->added_by)
                    || ($this->editLeavePermission == 'owned' && user()->id == $row->user_id)
                    || ($this->editLeavePermission == 'both' && (user()->id == $row->user_id || user()->id == $row->added_by))
                    ) {
                        $actions .= '<a class="dropdown-item openRightModal" href="' . route('annualLeave.edit', [$row->id]) . '">
                                <i class="fa fa-edit mr-2"></i>
                                ' . __('app.edit') . '
                        </a>';
                    }
                    if ($this->deleteLeavePermission == 'all'
                    || ($this->deleteLeavePermission == 'added' && user()->id == $row->added_by)
                    || ($this->deleteLeavePermission == 'owned' && user()->id == $row->user_id)
                    || ($this->deleteLeavePermission == 'both' && (user()->id == $row->user_id || user()->id == $row->added_by))
                    ) {
                        $actions .= '<a data-leave-id=' . $row->id . '
                                class="dropdown-item delete-table-row" href="javascript:;">
                                   <i class="fa fa-trash mr-2"></i>
                                    ' . __('app.delete') . '
                            </a>';
                    }
                }


                $actions .= '</div> </div> </div>';

                return $actions;*/
            })
                ->smart(false)
                ->setRowId(function ($row) {
                    return 'row-' . $row->id;
                })
            ->rawColumns(['status', 'action', 'check', 'employee']);
    }

    /**
     * @param Leave $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(solde_tout_compte $model)
    {
        
        $setting = global_setting();

        return $model->with('user', 'user.employeeDetail', 'user.employeeDetail.designation', 'user.session')
            ->join('users', 'solde_tout_comptes.user_id', 'users.id')
            ->select('solde_tout_comptes.*');

        


        
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('leaves-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2)
            ->destroy(true)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->dom($this->domHtml)

            ->language(__('app.datatable'))
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["leaves-table"].buttons().container()
                    .appendTo("#table-actions")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    });
                    $(".statusChange").selectpicker();
                }',
            ])
            ->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> ' . trans('app.exportExcel')]));
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
            __('app.id') => ['data' => 'id', 'name' => 'id', 'title' => __('app.id')],
            __('app.employee') => ['data' => 'employee', 'name' => 'user.name', 'exportable' => false, 'title' => __('app.employee')],
            //__('app.name') => ['data' => 'user.name', 'name' => 'user.name', 'exportable' => true, 'title' => __('app.name') ],
            //__('app.lastname') => ['data' => 'user.lastname', 'name' => 'user.lastname', 'exportable' => true, 'title' => __('app.lastname')],
            'Date fin contrat' => ['data' => 'fin_contrat', 'name' => 'fin_contrat', 'title' => 'Date fin contrat'],
            'Type de rupture de contrat' => ['data' => 'type', 'name' => 'type', 'title' => 'Type de rupture de contrat'],
            'Gratification' => ['data' => 'gratification', 'name' => 'gratification', 'title' => 'Gratification'],
            'Indemnité de congés' => ['data' => 'indemnite_conge', 'name' => 'indemnite_conge', 'title' => 'Indemnité de congés'],
            'Salaire net du mois' => ['data' => 'salaire_net_du_mois', 'name' => 'salaire_net_du_mois', 'title' => 'Salaire net du mois'],
            'Indemnité de licenciement' => ['data' => 'indemnite_licenciement', 'name' => 'indemnite_licenciement', 'title' => 'Indemnité de licenciement'],
            'Salaire de préavis' => ['data' => 'salaire_preavis', 'name' => 'salaire_preavis', 'title' => 'Salaire de préavis'],
            'Indemnité de fin de contrat' => ['data' => 'indemnite_de_fin_de_contrat', 'name' => 'indemnite_de_fin_de_contrat', 'title' => 'Indemnité de fin de contrat'],
            'Solde de tout compte' => ['data' => 'solde_tout_compte', 'name' => 'solde_tout_compte', 'title' => 'Solde de tout compte'],
            /*Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-right pr-20')*/
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'solde_tout_compte' . date('YmdHis');
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
