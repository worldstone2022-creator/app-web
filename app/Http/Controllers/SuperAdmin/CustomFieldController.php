<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Requests\CustomField\StoreCustomField;
use App\Models\CustomField;
use App\Models\CustomFieldGroup;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomFieldController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.customFields';
        $this->activeSettingMenu = 'custom_fields';
        $this->middleware(function ($request, $next) {
            abort_403(GlobalSetting::validateSuperAdmin('manage_superadmin_custom_field_settings'));
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (\request()->ajax()) {
            $permissions = CustomField::join('custom_field_groups', 'custom_field_groups.id', '=', 'custom_fields.custom_field_group_id')
                ->select('custom_fields.id', 'custom_field_groups.name as module', 'custom_fields.label', 'custom_fields.type', 'custom_fields.values', 'custom_fields.required')
                ->whereNull('custom_fields.company_id')
                ->get();

            $data = DataTables::of($permissions)
                ->editColumn(
                    'values',
                    function ($row) {
                        $ul = '--';

                        if (isset($row->values) && $row->values != '[null]') {
                            $ul = '<ul class="value-list">';

                            foreach (json_decode($row->values) as $key => $value) {
                                $ul .= '<li>' . $value . '</li>';
                            }

                            $ul .= '</ul>';
                        }

                        return $ul;
                    }
                )
                ->editColumn(
                    'required',
                    function ($row) {
                        // Edit Button
                        $string = ' - ';
                        $class = 'badge badge-danger disabled color-palette';

                        if ($row->required === 'yes') {
                            $string = '<span class="' . $class . '">' . __('app.' . $row->required) . '</span>';
                        }

                        if ($row->required === 'no') {
                            $class = 'badge badge-secondary disabled color-palette';
                            $string = '<span class="' . $class . '">' . __('app.' . $row->required) . '</span>';
                        }

                        return $string;
                    }
                )
                ->addColumn(
                    'action',
                    function ($row) {

                        return '<div class="task_view-quentin"> <a data-user-id="' . $row->id . '" class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-custom-field" href="javascript:;" data-id="{{ $permission->id }}" > <i class="fa fa-edit icons mr-2"></i>' . __('app.edit') . '</a> </div>
                    <div class="task_view-quentin"> <a data-user-id="' . $row->id . '" class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin sa-params" href="javascript:;" data-id="{{ $permission->id }}"  >
                            <i class="fa fa-trash icons mr-2"></i> ' . __('app.delete') . ' </a> </div>';
                    }
                )
                ->rawColumns(['values', 'action', 'required'])
                ->make(true);

            return $data;
        }

        return view('super-admin.custom-fields.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->customFieldGroups = CustomFieldGroup::whereNull('company_id')->get();
        $this->types = ['text', 'number', 'password', 'textarea', 'select', 'radio', 'date', 'checkbox', 'file'];
        return view('super-admin.custom-fields.create-custom-field-modal', $this->data);
    }

    /**
     * @param StoreCustomField $request
     * @return array
     */
    public function store(StoreCustomField $request)
    {
        $name = CustomField::generateUniqueSlug($request->get('label'), $request->module);
        $group = [
            'fields' => [
                [
                    'name' => $name,
                    'custom_field_group_id' => $request->module,
                    'label' => $request->get('label'),
                    'type' => $request->get('type'),
                    'required' => $request->get('required'),
                    'values' => $request->get('value'),
                    'export' => $request->get('export'),
                ]
            ],

        ];

        $this->addCustomField($group);

        return Reply::success('messages.recordSaved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->field = CustomField::findOrFail($id);
        $this->field->values = json_decode($this->field->values);

        return view('super-admin.custom-fields.edit-custom-field-modal', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $field = CustomField::findOrFail($id);
        $name = CustomField::generateUniqueSlug($request->label, $field->custom_field_group_id);
        $field->label = $request->label;
        $field->name = $name;
        $field->values = json_encode($request->value);
        $field->required = $request->required;
        $field->export = $request->export;
        $field->save();

        return Reply::success('messages.updateSuccess');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomField::destroy($id);

        return Reply::success('messages.deleteSuccess');
    }

    private function addCustomField($group)
    {
        // Add Custom Fields for this group
        foreach ($group['fields'] as $field) {
            $insertData = [
                'custom_field_group_id' => $field['custom_field_group_id'],
                'label' => $field['label'],
                'name' => $field['name'],
                'type' => $field['type'],
                'export' => $field['export']
            ];

            if (isset($field['required']) && (in_array($field['required'], ['yes', 'on', 1]))) {
                $insertData['required'] = 'yes';

            }
            else {
                $insertData['required'] = 'no';
            }

            // Single value should be stored as text (multi value JSON encoded)
            if (isset($field['values'])) {
                if (is_array($field['values'])) {
                    $insertData['values'] = \GuzzleHttp\json_encode($field['values']);

                }
                else {
                    $insertData['values'] = $field['values'];
                }
            }

            CustomField::create($insertData);

        }
    }

}
