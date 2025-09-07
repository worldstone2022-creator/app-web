<?php

namespace App\Http\Controllers;

use App\DataTables\ClientContactsDataTable;
use App\DataTables\ClientGDPRDataTable;
use App\DataTables\ClientNotesDataTable;
use App\DataTables\ClientsDataTable;
use App\DataTables\CreditNotesDataTable;
use App\DataTables\EstimatesDataTable;
use App\DataTables\InvoicesDataTable;
use App\DataTables\OrdersDataTable;
use App\DataTables\PaymentsDataTable;
use App\DataTables\ProjectsDataTable;
use App\DataTables\TicketDataTable;
use App\Enums\Salutation;
use App\Events\NewUserEvent;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\AppSettingController;
use App\Http\Requests\Admin\Client\StoreClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;
use App\Http\Requests\Admin\Employee\ImportProcessRequest;
use App\Http\Requests\Admin\Employee\ImportRequest;
use App\Http\Requests\Gdpr\SaveConsentUserDataRequest;
use App\Imports\ClientImport;
use App\Jobs\ImportClientJob;
use App\Models\BaseModel;
use App\Models\ClientCategory;
use App\Models\ClientContact;
use App\Models\ClientDetails;
use App\Models\ClientNote;
use App\Models\ClientSubCategory;
use App\Models\ContractType;
use App\Models\Invoice;
use App\Models\LanguageSetting;
use App\Models\Lead;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Project;
use App\Models\ProjectStatusSetting;
use App\Models\PurposeConsent;
use App\Models\PurposeConsentUser;
use App\Models\RegimeImpot;
use App\Models\Role;
use App\Models\UniversalSearch;
use App\Models\User;
use App\Models\UserAuth;
use App\Scopes\ActiveScope;
use App\Scopes\CompanyScope;
use App\Traits\EmployeeActivityTrait;
use App\Traits\ImportExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends AccountBaseController
{

    use ImportExcel;
    use EmployeeActivityTrait;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.clients';
        $this->middleware(function ($request, $next) {
            abort_403(!in_array('clients', $this->user->modules));
            return $next($request);
        });
    }

    /**
     * client list
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientsDataTable $dataTable)
    {
        $viewPermission = user()->permission('view_clients');
        $this->addClientPermission = user()->permission('add_clients');

        abort_403(!in_array($viewPermission, ['all', 'added', 'both']));

        if (!request()->ajax()) {
            $this->clients = User::allClients(active:false);
            $this->subcategories = ClientSubCategory::all();
            $this->categories = ClientCategory::all();
            $this->projects = Project::all();
            $this->contracts = ContractType::all();
            $this->countries = countries();
            $this->totalClients = count($this->clients);
        }

        return $dataTable->render('clients.index', $this->data);
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function create($leadID = null)
    {
        $this->addPermission = user()->permission('add_clients');

        abort_403(!in_array($this->addPermission, User::ALL_ADDED_BOTH));

        if ($leadID) {
            $this->leadDetail = Lead::findOrFail($leadID);
        }

        if (request('lead') != '') {
            $this->leadId = request('lead');
            $this->type = 'lead';
            $this->lead = Lead::findOrFail($this->leadId);
        }

        if ($this->addPermission == 'all') {
            $this->employees = User::allEmployees(null,true);
        }

        $this->pageTitle = __('app.addClient');
        $this->countries = countries();
        $this->categories = ClientCategory::all();
        $this->salutations = Salutation::cases();
        $this->languages = LanguageSetting::where('status', 'enabled')->get();

        $client = new ClientDetails();
        $getCustomFieldGroupsWithFields = $client->getCustomFieldGroupsWithFields();

        if ($getCustomFieldGroupsWithFields) {
            $this->fields = $getCustomFieldGroupsWithFields->fields;
        }

        $this->view = 'clients.ajax.create';

        if (request()->ajax()) {
            if (request('quick-form') == 1) {
                return view('clients.ajax.quick_create', $this->data);
            }

            return $this->returnAjax($this->view);
        }


        return view('clients.create', $this->data);
    }



      public function createTiers($leadID = null)
    {
        $this->addPermission = user()->permission('add_clients');

        abort_403 (!($this->addPermission == 'all' || $this->addPermission == 'added' || $this->addPermission == 'both'));

        if ($leadID) {
            $this->leadDetail = Lead::findOrFail($leadID);
        }

        if (request('lead') != '') {
            $this->leadId = request('lead');
            $this->type = 'lead';
            $this->lead = Lead::findOrFail($this->leadId);
        }

        $this->pageTitle = __('app.add') . ' ' . __('app.client');
        $this->countries = countries();
        $this->categories = ClientCategory::all();
        $this->RegimeImpots = RegimeImpot::all();
        $this->salutations = ['mr','miss', 'madam'];

        $client = new ClientDetails();

        if (!empty($client->getCustomFieldGroupsWithFields())) {
            $this->fields = $client->getCustomFieldGroupsWithFields()->fields;
        }

        return view('tiers.create', $this->data);
        
    }


    /**
     * XXXXXXXXXXX
     *
     * @return array
     */
    public function store(StoreClientRequest $request)
    {

        DB::beginTransaction();

        $data = $request->all();
        unset($data['country']);
        unset($data['is_client_contact']);

        if ($request->email != '') {
            $userAuth = UserAuth::createUserAuthCredentials($request->email, $request->password);
            $data['user_auth_id'] = $userAuth->id;
        }

        $data['country_id'] = $request->country;
        $data['name'] = $request->name;
        $data['email_notifications'] = $request->sendMail == 'yes' ? 1 : 0;
        $data['gender'] = $request->gender ?? null;
        $data['locale'] = $request->locale ?? 'en';

        if ($request->has('telegram_user_id')) {
            $data['telegram_user_id'] = $request->telegram_user_id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = Files::uploadLocalOrS3($request->image, 'avatar', 300);
        }

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = Files::uploadLocalOrS3($request->company_logo, 'client-logo', 300);
        }

        if($request->has('is_client_contact')){
            $data['email_notifications'] = 1;
        }

        $user = User::create($data);
        $user->clientDetails()->create($data);
        $client_id = $user->id;

        if($request->has('is_client_contact')){
            $clientContact = new ClientContact();
            $clientContact->user_id = $request->is_client_contact;
            $clientContact->contact_name = $request->name;
            $clientContact->phone = $request->mobile;
            $clientContact->email = $request->email;
            $clientContact->title = $request->title;
            $clientContact->address = $request->address;
            $clientContact->added_by = user()->id;
            $clientContact->last_updated_by = user()->id;
            $clientContact->client_id = $client_id;
            $clientContact->save();

            $user->is_client_contact = $clientContact->id;
            $client = User::withoutGlobalScope(ActiveScope::class)->where('id', $clientContact->user_id)->first();
            $user->status = $client->status;
            $user->update();
        }

        $client_note = new ClientNote();
        $note = trim_editor($request->note);

        if ($note != '') {
            $client_note->title = 'Note';
            $client_note->client_id = $client_id;
            $client_note->details = $note;
            $client_note->save();
        }

        // To add custom fields data
        if ($request->custom_fields_data) {
            $client = $user->clientDetails;
            $client->updateCustomFieldData($request->custom_fields_data);
        }

        $role = Role::where('name', 'client')->select('id')->first();
        $user->attachRole($role->id);

        $user->assignUserRolePermission($role->id);

        // Log search
        $this->logSearchEntry($user->id, $user->name, 'clients.show', 'client');

        if (!is_null($user->email)) {
            $this->logSearchEntry($user->id, $user->email, 'clients.show', 'client');
        }

        if (!is_null($user->clientDetails->company_name)) {
            $this->logSearchEntry($user->id, $user->clientDetails->company_name, 'clients.show', 'client');
        }

        if ($request->has('lead')) {
            $lead = Lead::findOrFail($request->lead);
            $lead->client_id = $user->id;
            $lead->save();
        }

        DB::commit();

        $redirectUrl = urldecode($request->redirect_url);

        if ($redirectUrl == '') {
            $redirectUrl = route('clients.index');
        }

        if($request->has('is_client_contact')){
            $redirectUrl = route('clients.show', $request->is_client_contact) . '?tab=contacts';
        }

        if ($request->add_more == 'true') {
            $html = $this->create();

            return Reply::successWithData(__('messages.recordSaved'), ['html' => $html, 'add_more' => true]);
        }

        if ($request->has('ajax_create')) {
            $projects = Project::all();
            $teams = User::allClients();
            $options = BaseModel::options($projects, null, 'project_name');

            $teamData = '';

            foreach ($teams as $team) {
                $selected = ($team->id == $user->id) ? 'selected' : '';

                $teamData .= '<option ' . $selected . ' data-content="';

                $teamData .= '<div class=\'media align-items-center mw-250\'>';

                $teamData .= '<div class=\'position-relative\'><img src=' . $team->image_url . ' class=\'mr-2 taskEmployeeImg rounded-circle\'></div>';
                $teamData .= '<div class=\'media-body\'>';
                $teamData .= '<h5 class=\'mb-0 f-13\'>' . $team->name . '</h5>';
                $teamData .= '<p class=\'my-0 f-11 text-dark-grey\'>' . $team->email . '</p>';

                $teamData .= (!is_null($team->clientDetails->company_name)) ? '<p class=\'my-0 f-11 text-dark-grey\'>' . $team->clientDetails->company_name . '</p>' : '';
                $teamData .= '</div>';
                $teamData .= '</div>"';

                $teamData .= 'value="' . $team->id . '"> ' . $team->name . '';

                $teamData .= '</option>';
            }

            return Reply::successWithData(__('messages.recordSaved'), ['teamData' => $teamData, 'project' => $options, 'redirectUrl' => $redirectUrl]);
        }

        return Reply::successWithData(__('messages.recordSaved'), ['redirectUrl' => $redirectUrl]);
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->client = User::withoutGlobalScope(ActiveScope::class)->with('clientDetails')->findOrFail($id);
        $this->emailCountInCompanies = User::withoutGlobalScopes([ActiveScope::class, CompanyScope::class])
            ->where('email', $this->client->email)
            ->whereNotNull('email')
            ->count();

        $this->editPermission = user()->permission('edit_clients');

        abort_403(!($this->editPermission == 'all' || ($this->editPermission == 'added' && $this->client->clientDetails->added_by == user()->id) || ($this->editPermission == 'both' && $this->client->clientDetails->added_by == user()->id)));

        $this->countries = countries();
        $this->categories = ClientCategory::all();

        if ($this->editPermission == 'all') {
            $this->employees = User::allEmployees();
        }

        $this->pageTitle = __('app.update') . ' ' . __('app.client');
        $this->salutations = Salutation::cases();
        $this->languages = LanguageSetting::where('status', 'enabled')->get();

        if (!is_null($this->client->clientDetails)) {
            $this->clientDetail = $this->client->clientDetails->withCustomFields();

            $getCustomFieldGroupsWithFields = $this->clientDetail->getCustomFieldGroupsWithFields();

            if ($getCustomFieldGroupsWithFields) {
                $this->fields = $getCustomFieldGroupsWithFields->fields;
            }
        }

        $this->subcategories = ClientSubCategory::all();

        $this->view = 'clients.ajax.edit';

        if (request()->ajax()) {
            return $this->returnAjax($this->view);
        }

        return view('clients.create', $this->data);

    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {
        $user = User::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        $data = $request->all();

        // if(isWorksuiteSaas()) {
        //     if($user->email != $request->email) {
        //         if(is_null($request->password)){
        //             $userAuth = UserAuth::createUserAuthCredentials($request->email, $request->password);
        //             $data['user_auth_id'] = $userAuth->id;
        //         }
        //     }
        //     else {
        //         unset($data['email']);
        //     }
        // }

        // unset($data['password']);
        unset($data['country']);
        unset($data['is_client_contact']);

        if ($request->status != $user->status) {
            $clientIds = ClientContact::where('user_id', $user->id)->pluck('client_id');
            User::withoutGlobalScope(ActiveScope::class)->whereIn('id', $clientIds)->update(['status' => $request->status]);
        }

        $data['country_id'] = $request->country;

        if ($request->has('sendMail')) {
            $user->email_notifications = $request->sendMail == 'yes' ? 1 : 0;
        }

        if ($request->has('telegram_user_id')) {
            $data['telegram_user_id'] = $request->telegram_user_id;
        }


        if ($request->image_delete == 'yes') {
            Files::deleteFile($user->image, 'avatar');
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {

            Files::deleteFile($user->image, 'avatar');
            $data['image'] = Files::uploadLocalOrS3($request->image, 'avatar', 300);
        }

        if($request->has('is_client_contact')){
            $clientContact = ClientContact::findOrFail($request->client_contact_id);
            $clientContact->user_id = $request->is_client_contact;
            $clientContact->contact_name = $request->name;
            $clientContact->phone = $request->mobile;
            $clientContact->email = $request->email;
            $clientContact->title = $request->title;
            $clientContact->address = $request->address;
            $clientContact->last_updated_by = user()->id;
            $clientContact->save();
        }

        $user->update($data);

        if ($user->clientDetails) {
            $data['category_id'] = $request->category_id;
            $data['sub_category_id'] = $request->sub_category_id;
            $data['note'] = trim_editor($request->note);
            $data['locale'] = $request->locale;
            $fields = $request->only($user->clientDetails->getFillable());

            if ($request->has('company_logo_delete') && $request->company_logo_delete == 'yes') {
                Files::deleteFile($user->clientDetails->company_logo, 'client-logo');
                $fields['company_logo'] = null;
            }

            if ($request->hasFile('company_logo')) {
                Files::deleteFile($user->clientDetails->company_logo, 'client-logo');
                $fields['company_logo'] = Files::uploadLocalOrS3($request->company_logo, 'client-logo', 300);
            }

            $user->clientDetails->fill($fields);
            $user->clientDetails->save();

        }
        else {
            $user->clientDetails()->create($data);
        }

        // To add custom fields data
        if ($request->custom_fields_data) {
            $user->clientDetails->updateCustomFieldData($request->custom_fields_data);
        }

        $this->createEmployeeActivity(auth()->user()->id, 'client-updated', $id, 'client');


        $redirectUrl = urldecode($request->redirect_url);

        if ($redirectUrl == '') {
            $redirectUrl = route('clients.index');
        }

        if($request->has('is_client_contact')){
            $redirectUrl = route('clients.show', $request->is_client_contact) . '?tab=contacts';
        }

        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => $redirectUrl]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->client = User::withoutGlobalScope(ActiveScope::class)->with('clientDetails')->findOrFail($id);
        $this->deletePermission = user()->permission('delete_clients');

        abort_403(
            !($this->deletePermission == 'all'
                || ($this->deletePermission == 'added' && $this->client->clientDetails->added_by == user()->id)
                || ($this->deletePermission == 'both' && $this->client->clientDetails->added_by == user()->id)
            )
        );

        $this->deleteClient($this->client);

        return Reply::success(__('messages.deleteSuccess'));
    }

    private function deleteClient(User $user)
    {
        $universalSearches = UniversalSearch::where('searchable_id', $user->id)->where('module_type', 'client')->get();

        if ($universalSearches) {
            foreach ($universalSearches as $universalSearch) {
                UniversalSearch::destroy($universalSearch->id);
            }
        }


        Notification::whereNull('read_at')
            ->where(function ($q) use ($user) {
                $q->where('data', 'like', '{"id":' . $user->id . ',%');
                $q->orWhere('data', 'like', '%,"name":' . $user->name . ',%');
                $q->orWhere('data', 'like', '%,"user_one":' . $user->id . ',%');
                $q->orWhere('data', 'like', '%,"client_id":' . $user->id . '%');
            })->delete();

        $user->delete();

        Lead::where('client_id', $user->id)->update(['client_id' => null]);
        $this->createEmployeeActivity(auth()->user()->id, 'client-deleted');

        session()->forget('company');

        return Reply::success(__('messages.deleteSuccess'));

    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function applyQuickAction(Request $request)
    {
        switch ($request->action_type) {
        case 'delete':
            $this->deleteRecords($request);

            return Reply::success(__('messages.deleteSuccess'));
        case 'change-status':
            $this->changeStatus($request);

            return Reply::success(__('messages.updateSuccess'));
        default:
            return Reply::error(__('messages.selectAction'));
        }
    }

    protected function deleteRecords($request)
    {
        abort_403(user()->permission('delete_clients') !== 'all');
        $users = User::withoutGlobalScope(ActiveScope::class)->whereIn('id', explode(',', $request->row_ids))->get();
        $users->each(function ($user) {
            $this->deleteClient($user);
        });

        return true;
    }

    protected function changeStatus($request)
    {
        abort_403(user()->permission('edit_clients') !== 'all');
        User::withoutGlobalScope(ActiveScope::class)
            ->whereIn('id', explode(',', $request->row_ids))
            ->update(['status' => $request->status]);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->client = User::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        $this->clientLanguage = LanguageSetting::where('language_code', $this->client->locale)->first();
        $this->viewPermission = user()->permission('view_clients');
        $this->viewDocumentPermission = user()->permission('view_client_document');

        if (!$this->client->hasRole('client')) {
            abort(404);
        }

        abort_403(!($this->viewPermission == 'all'
            || ($this->viewPermission == 'added' && $this->client->clientDetails->added_by == user()->id)
            || ($this->viewPermission == 'both' && $this->client->clientDetails->added_by == user()->id)));

        $this->pageTitle = $this->client->name;

        $this->clientStats = $this->clientStats($id);
        $this->projectChart = $this->projectChartData($id);
        $this->invoiceChart = $this->invoiceChartData($id);

        $this->earningTotal = Payment::leftJoin('invoices', 'invoices.id', '=', 'payments.invoice_id')
            ->leftJoin('projects', 'projects.id', '=', 'payments.project_id')
            ->where(function ($q) use ($id) {
                $q->where('invoices.client_id', $id);
                $q->orWhere('projects.client_id', $id);
            })->sum('amount');

        $this->view = 'clients.ajax.profile';

        $tab = request('tab');

        switch ($tab) {
        case 'projects':
            return $this->projects();
        case 'invoices':
            return $this->invoices();
        case 'payments':
            return $this->payments();
        case 'estimates':
            return $this->estimates();
        case 'creditnotes':
            return $this->creditnotes();
        case 'contacts':
            return $this->contacts();
        case 'orders':
            return $this->orders();
        case 'documents':
            abort_403(!($this->viewDocumentPermission == 'all'
                || ($this->viewDocumentPermission == 'added' && $this->client->clientDetails->added_by == user()->id)
                || ($this->viewDocumentPermission == 'owned' && $this->client->clientDetails->user_id == user()->id)
                || ($this->viewDocumentPermission == 'both' && ($this->client->clientDetails->added_by == user()->id || $this->client->clientDetails->user_id == user()->id))));

            $this->view = 'clients.ajax.documents';
            break;
        case 'notes':
            return $this->notes();
        case 'tickets':
            return $this->tickets();
        case 'gdpr':
            $this->client = User::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            $this->consents = PurposeConsent::with(['user' => function ($query) use ($id) {
                $query->where('client_id', $id)
                    ->orderByDesc('created_at');
            }])->get();

            return $this->gdpr();
        default:
            $this->clientDetail = ClientDetails::where('user_id', '=', $this->client->id)->first();

            if (!is_null($this->clientDetail)) {
                $this->clientDetail = $this->clientDetail->withCustomFields();

                $getCustomFieldGroupsWithFields = $this->clientDetail->getCustomFieldGroupsWithFields();

                if ($getCustomFieldGroupsWithFields) {
                    $this->fields = $getCustomFieldGroupsWithFields->fields;
                }
            }

            $this->view = 'clients.ajax.profile';
            break;
        }

        if (request()->ajax()) {
            return $this->returnAjax($this->view);
        }

        $this->activeTab = $tab ?: 'profile';

        return view('clients.show', $this->data);

    }

    public function clientStats($id)
    {
        return DB::table('users')
            ->select(
                DB::raw('(select count(projects.id) from `projects` WHERE projects.client_id = ' . $id . ' and deleted_at IS NULL) as totalProjects'),
                DB::raw('(select count(invoices.id) from `invoices` left join projects on projects.id=invoices.project_id WHERE invoices.status != "paid" and invoices.status != "canceled" and (projects.client_id = ' . $id . ' or invoices.client_id = ' . $id . ')) as totalUnpaidInvoices'),
                DB::raw('(select sum(payments.amount) from `payments` left join projects on projects.id=payments.project_id WHERE payments.status = "complete" and projects.client_id = ' . $id . ') as projectPayments'),
                DB::raw('(select sum(payments.amount) from `payments` inner join invoices on invoices.id=payments.invoice_id  WHERE payments.status = "complete" and invoices.client_id = ' . $id . ') as invoicePayments'),
                DB::raw('(select count(contracts.id) from `contracts` WHERE contracts.client_id = ' . $id . ') as totalContracts')
            )
            ->first();
    }

    /**
     * XXXXXXXXXXX
     *
     * @return array
     */
    public function projectChartData($id)
    {
        // Fetch active project status settings
        $statusSettings = ProjectStatusSetting::where('status', 'active')->get();

        // Initialize data array
        $data = [
            'labels' => $statusSettings->pluck('status_name')->toArray(),
            'colors' => $statusSettings->pluck('color')->toArray(),
            'values' => []
        ];

        // Construct the query to count projects for each status
        $query = Project::selectRaw('COUNT(*) as count, status')
            ->where('client_id', $id)
            ->whereIn('status', $data['labels'])
            ->groupBy('status');

        // Execute the query and fetch counts for each status
        $statusCounts = $query->pluck('count', 'status');

        // Populate the values array with counts for each status
        foreach ($data['labels'] as $label) {
            $data['values'][] = $statusCounts[$label] ?? 0;
        }

        return $data;
    }

    /**
     * XXXXXXXXXXX
     *
     * @return array
     */
    public function invoiceChartData($id)
    {
        // Define labels, translations, and colors
        $labels = ['paid', 'unpaid', 'partial', 'canceled', 'draft'];
        $translations = [__('app.paid'), __('app.unpaid'), __('app.partial'), __('app.canceled'), __('app.draft')];
        $colors = ['#2CB100', '#FCBD01', '#1d82f5', '#D30000', '#616e80'];

        // Construct the query to count invoices for each status
        $query = Invoice::selectRaw('COUNT(*) as count, status')
            ->where('client_id', $id)
            ->whereIn('status', $labels)
            ->groupBy('status');

        // Execute the query and fetch counts for each status
        $statusCounts = $query->pluck('count', 'status');

        // Initialize data array
        $data = [
            'labels' => $translations,
            'colors' => $colors,
            'values' => []
        ];

        // Populate the values array with counts for each status
        foreach ($labels as $label) {
            $data['values'][] = $statusCounts[$label] ?? 0;
        }

        return $data;
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function projectList($id)
    {
        if ($id != 0) {
            $projects = Project::where('client_id', $id)->get();
            $options = BaseModel::options($projects, null, 'project_name');

        }
        else {
            $options = '<option value="">--</option>';
        }

        return Reply::dataOnly(['status' => 'success', 'data' => $options]);
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxDetails($id)
    {
        if ($id != 0) {
            $client = User::withoutGlobalScope(ActiveScope::class)->with('clientDetails', 'country')->find($id);

        }
        else {
            $client = null;
        }

        $clientProjects = Project::where('client_id', $id)->get();

        $options = '<option value="">--</option>';

        foreach ($clientProjects as $project) {

            $options .= '<option value="' . $project->id . '"> ' . $project->project_name . ' </option>';
        }

        $data = $client ?: null;

        return Reply::dataOnly(['status' => 'success', 'data' => $data, 'project' => $options]);
    }

    public function projects()
    {

        $viewPermission = user()->permission('view_projects');

        abort_403(!($viewPermission == 'all' || $viewPermission == 'added'));
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.projects';

        $dataTable = new ProjectsDataTable();

        return $dataTable->render('clients.show', $this->data);

    }

    public function invoices()
    {
        $dataTable = new InvoicesDataTable();
        $viewPermission = user()->permission('view_invoices');

        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));
        $tab = request('tab');

        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.invoices';

        return $dataTable->render('clients.show', $this->data);
    }

    public function payments()
    {
        $dataTable = new PaymentsDataTable();
        $viewPermission = user()->permission('view_payments');

        abort_403(!($viewPermission == 'all' || $viewPermission == 'added'));
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.payments';

        return $dataTable->render('clients.show', $this->data);

    }

    public function estimates()
    {
        $dataTable = new EstimatesDataTable();
        $viewPermission = user()->permission('view_estimates');

        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));

        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';
        $this->view = 'clients.ajax.estimates';

        return $dataTable->render('clients.show', $this->data);
    }

    public function creditnotes()
    {
        $dataTable = new CreditNotesDataTable();
        $viewPermission = user()->permission('view_invoices');

        abort_403($viewPermission == 'none');
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';
        $this->view = 'clients.ajax.credit_notes';

        return $dataTable->render('clients.show', $this->data);
    }

    public function contacts()
    {
        $dataTable = new ClientContactsDataTable();
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.contacts';

        return $dataTable->render('clients.show', $this->data);
    }

    public function notes()
    {
        $dataTable = new ClientNotesDataTable();
        $viewPermission = user()->permission('view_client_note');

        abort_403(($viewPermission == 'none'));
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';
        $this->view = 'clients.ajax.notes';

        return $dataTable->render('clients.show', $this->data);
    }

    public function tickets()
    {
        $dataTable = new TicketDataTable();
        $viewPermission = user()->permission('view_clients');

        abort_403(!($viewPermission == 'all' || $viewPermission == 'added' || $viewPermission == 'both'));
        $tab = request('tab');
        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.tickets';

        return $dataTable->render('clients.show', $this->data);
    }

    public function gdpr()
    {
        $dataTable = new ClientGDPRDataTable();
        $tab = request('tab');
        $this->activeTab = $tab ?: 'gdpr';

        $this->view = 'clients.ajax.gdpr';

        return $dataTable->render('clients.show', $this->data);
    }

    public function consent(Request $request)
    {
        $clientId = $request->clientId;
        $this->consentId = $request->consentId;
        $this->clientId = $clientId;

        $this->consent = PurposeConsent::with(['user' => function ($query) use ($request) {
            $query->where('client_id', $request->clientId)
                ->orderByDesc('created_at');
        }])
            ->where('id', $request->consentId)
            ->first();

        return view('clients.gdpr.consent-form', $this->data);
    }

    public function saveClientConsent(SaveConsentUserDataRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $consent = PurposeConsent::findOrFail($request->consent_id);

        if ($request->consent_description && $request->consent_description != '') {
            $consent->description = trim_editor($request->consent_description);
            $consent->save();
        }

        // Saving Consent Data
        $newConsentLead = new PurposeConsentUser();
        $newConsentLead->client_id = $user->id;
        $newConsentLead->purpose_consent_id = $consent->id;
        $newConsentLead->status = trim($request->status);
        $newConsentLead->ip = $request->ip();
        $newConsentLead->updated_by_id = $this->user->id;
        $newConsentLead->additional_description = $request->additional_description;
        $newConsentLead->save();

        return $request->status == 'agree' ? Reply::success(__('messages.consentOptIn')) : Reply::success(__('messages.consentOptOut'));
    }

    public function approve($id)
    {
        abort_403(!in_array('admin', user_roles()));

        User::where('id', $id)->update(
            ['admin_approval' => 1]
        );

        $userSession = new AppSettingController();
        $userSession->deleteSessions([$id]);

        $password = session('auth_pass');
        $client = User::where('id', $id)->first();

        event(new NewUserEvent($client, $password, true));

        return Reply::success(__('messages.updateSuccess'));
    }

    public function importClient()
    {
        $this->pageTitle = __('app.importExcel') . ' ' . __('app.client');

        $addPermission = user()->permission('add_clients');
        abort_403(!in_array($addPermission, ['all', 'added', 'both']));

        $this->view = 'clients.ajax.import';

        if (request()->ajax()) {
            return $this->returnAjax($this->view);
        }

        return view('clients.create', $this->data);
    }

    public function importStore(ImportRequest $request)
    {
        $rvalue = $this->importFileProcess($request, ClientImport::class);

        if($rvalue == 'abort'){
            return Reply::error(__('messages.abortAction'));
        }

        $view = view('clients.ajax.import_progress', $this->data)->render();

        return Reply::successWithData(__('messages.importUploadSuccess'), ['view' => $view]);
    }

    public function importProcess(ImportProcessRequest $request)
    {
        $batch = $this->importJobProcess($request, ClientImport::class, ImportClientJob::class);

        return Reply::successWithData(__('messages.importProcessStart'), ['batch' => $batch]);
    }

    public function financeCount(Request $request)
    {
        $id = $request->id;

        $counts = User::withCount('projects', 'invoices', 'estimates')->withoutGlobalScope(ActiveScope::class)->find($id);

        $payments = Payment::leftJoin('invoices', 'invoices.id', '=', 'payments.invoice_id')
            ->leftJoin('projects', 'projects.id', '=', 'payments.project_id')
            ->leftJoin('orders', 'orders.id', '=', 'payments.order_id')
            ->where(function ($query) use ($id) {
                $query->where('projects.client_id', $id)
                    ->orWhere('invoices.client_id', $id)
                    ->orWhere('orders.client_id', $id);
            })->count();

        $projectName = $counts->projects_count > 1 ? __('app.menu.projects') : __('app.project');
        $invoiceName = $counts->invoices_count > 1 ? __('app.menu.invoices') : __('app.invoice');
        $estimateName = $counts->estimates_count > 1 ? __('app.menu.estimates') : __('app.estimate');
        $paymentName = $payments > 1 ? __('app.menu.payments') : __('app.payment');

        $deleteClient = (__('messages.clientFinanceCount', ['projectCount' => $counts->projects_count, 'invoiceCount' => $counts->invoices_count, 'estimateCount' => $counts->estimates_count, 'paymentCount' => $payments, 'project' => $projectName, 'invoice' => $invoiceName, 'estimate' => $estimateName, 'payment' => $paymentName]));

        return Reply::dataOnly(['status' => 'success', 'deleteClient' => $deleteClient]);
    }

    public function clientDetails(Request $request)
    {
        $teamData = '';

        if ($request->id == 0) {
            $clients = User::allClients();

            foreach ($clients as $client) {

                $teamData .= '<option data-content="';

                $teamData .= '<div class=\'media align-items-center mw-250\'>';

                $teamData .= '<div class=\'position-relative\'><img src=' . $client->image_url . ' class=\'mr-2 taskEmployeeImg rounded-circle\'></div>';
                $teamData .= '<div class=\'media-body\'>';
                $teamData .= '<h5 class=\'mb-0 f-13\'>' . $client->name . '</h5>';
                $teamData .= '<p class=\'my-0 f-11 text-dark-grey\'>' . $client->email . '</p>';

                $teamData .= (!is_null($client->clientDetails->company_name)) ? '<p class=\'my-0 f-11 text-dark-grey\'>' . $client->clientDetails->company_name . '</p>' : '';
                $teamData .= '</div>';
                $teamData .= '</div>"';

                $teamData .= 'value="' . $client->id . '"> ' . $client->name . '';

                $teamData .= '</option>';

            }
        }
        else {

            $project = Project::with('client')->findOrFail($request->id);

            if ($project->client != null) {

                $teamData .= '<option data-content="';

                $teamData .= '<div class=\'media align-items-center mw-250\'>';

                $teamData .= '<div class=\'position-relative\'><img src=' . $project->client->image_url . ' class=\'mr-2 taskEmployeeImg rounded-circle\'></div>';
                $teamData .= '<div class=\'media-body\'>';
                $teamData .= '<h5 class=\'mb-0 f-13\'>' . $project->client->name . '</h5>';
                $teamData .= '<p class=\'my-0 f-11 text-dark-grey\'>' . $project->client->email . '</p>';

                $teamData .= (!is_null($project->client->company->company_name)) ? '<p class=\'my-0 f-11 text-dark-grey\'>' . $project->client->company->company_name . '</p>' : '';
                $teamData .= '</div>';
                $teamData .= '</div>"';

                $teamData .= 'value="' . $project->client->id . '"> ' . $project->client->name . '';

                $teamData .= '</option>';
            }

        }

        return Reply::dataOnly(['teamData' => $teamData]);
    }

    public function orders()
    {
        $dataTable = new OrdersDataTable();
        $viewPermission = user()->permission('view_order');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));

        $tab = request('tab');

        $this->activeTab = $tab ?: 'profile';

        $this->view = 'clients.ajax.orders';

        return $dataTable->render('clients.show', $this->data);
    }

}
