<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helper\Reply;
use App\Http\Requests\solde_tout_compte\StoreRequest;
use App\Http\Requests\solde_tout_compte\UpdateRequest;
use App\Models\BaseModel;
use App\Models\Role;
use App\Models\Designation;
use App\Models\salaire_categoriel;
use App\Models\salaire_primeIndemnite;
use App\Models\salaire_taxe;
use App\Models\salaire_avance;

use App\Models\EmployeeDetails;
use App\Models\User;
use App\Models\TaskboardColumn;
use App\Models\Task;
use App\Models\ProjectTimeLog;
use App\Models\ProjectTimeLogBreak;
use App\Models\UserActivity;
use App\Models\annualLeave;
use App\Models\solde_tout_compte;

use App\DataTables\SoldeToutCompteDataTable;
use Auth;
use Log;
class accountBalanceController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.accountBalance';
        $this->middleware('auth');
        /*$this->middleware(function ($request, $next) {
            abort_403(!in_array('paie', $this->user->modules));
            return $next($request);
        });*/

    }

    /**
     * @param EmployeesDataTable $dataTable
     * @return mixed|void
     */
    public function index(SoldeToutCompteDataTable $dataTable)
    {
        $viewPermission = user()->permission('view_account_balance');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));
        //dd($viewPermission);
        if (!request()->ajax()) {
            $this->employees = User::allEmployees();
            $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
            $this->totalEmployees = count($this->employees);
            $this->designations = Designation::allDesignations();
            $this->roles = Role::where('name', '<>', 'client')
                ->orderBy('id', 'asc')->get();

        }
        //dd($this->data);
        return $dataTable->render('soldeToutCompte.index', $this->data);
    }


    public function create()
    {
        $this->pageTitle = "Ajouter solde de tout compte";
        $this->employees = User::allEmployeesEndContrat();
        

        if (request()->ajax()) {
            $html = view('soldeToutCompte.ajax.create', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }
        //dd($this->salaire_categoriels);
        $this->view = 'soldeToutCompte.ajax.create';

        return view('soldeToutCompte.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        //return $request->all();
        $solde=solde_tout_compte::where('user_id', $request->employee)->first();
        try{
            if ($solde) {
                // faire un update
                $solde = solde_tout_compte::find($solde->id);
                $solde->user_id = $request->employee;
                $solde->motif_end_contrat = $request->motif_end_contrat;
                $solde->gratification = $request->gratification;
                $solde->indemnite_conge = $request->indemnite_conge;
                $solde->salaire_net_du_mois = $request->salaire_net_du_mois;
                $solde->indemnite_licenciement = $request->indemnite_licenciement;
                $solde->salaire_preavis = $request->salaire_preavis;
                $solde->indemnite_de_fin_de_contrat = $request->indemnite_de_fin_de_contrat;
                $solde->solde_tout_compte = $request->solde_tout_compte;
                $solde->last_updated_by = Auth::user()->id;
                $solde->save();
            }else{
                //Faire un save
                $solde = new solde_tout_compte();
                $solde->user_id = $request->employee;
                $solde->motif_end_contrat = $request->motif_end_contrat;
                $solde->gratification = $request->gratification;
                $solde->indemnite_conge = $request->indemnite_conge;
                $solde->salaire_net_du_mois = $request->salaire_net_du_mois;
                $solde->indemnite_licenciement = $request->indemnite_licenciement;
                $solde->salaire_preavis = $request->salaire_preavis;
                $solde->indemnite_de_fin_de_contrat = $request->indemnite_de_fin_de_contrat;
                $solde->solde_tout_compte = $request->solde_tout_compte;
                $solde->added_by = Auth::user()->id;
                $solde->save();
            }
            return Reply::successWithData('Solde de tout compte édité avec succès', ['redirectUrl' => route('accountBalance.index')]);
        }catch (\Exception $e){
            Log::info($e);
            return Reply::error('Une erreur s\'est produite lors de l\'insertion des données. Veuillez réessayer');
        }

    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //EmployeeDetails::where('designation_id', $id)->update(['designation_id' => null]);
        salaire_categoriel::destroy($id);

        $salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $options = BaseModel::options($salaireCategoriel);

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }

    public function show($id)
    {
        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes', 'country', 'emergencyContacts'])->withoutGlobalScope('active')->with('employee')->withCount('member', 'agents', 'openTasks')->findOrFail($id);
        $this->salaireAVS =  DB::table('salaire_avances')
          ->select(DB::raw('SUM(reste_avs) as resteAVS'))
          ->where('user_id', $id)
          ->first();
        //salaire_avance::where('user_id', $id)->get();
        //dd($this->salaireAVS->resteAVS);
        $this->viewPermission = user()->permission('view_employees');
        $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $this->salairePrime = salaire_primeIndemnite::allsalairePrime();
        $this->salaireTaxe = salaire_taxe::allsalaireTaxe();
        if (!$this->employee->hasRole('employee')) {
            abort(404);
        }

        abort_403(!(
            $this->viewPermission == 'all'
            || ($this->viewPermission == 'added' && $this->employee->employeeDetail->added_by == user()->id)
            || ($this->viewPermission == 'owned' && $this->employee->employeeDetail->user_id == user()->id)
            || ($this->viewPermission == 'both' && ($this->employee->employeeDetail->user_id == user()->id || $this->employee->employeeDetail->added_by == user()->id))
        ));

        $this->pageTitle = ucfirst($this->employee->name.' '.$this->employee->lastname );

        if (!is_null($this->employee->employeeDetail)) {
            $this->employeeDetail = $this->employee->employeeDetail->withCustomFields();

            if (!empty($this->employeeDetail->getCustomFieldGroupsWithFields())) {
                $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
            }
        }

        $taskBoardColumn = TaskboardColumn::completeColumn();

        $this->taskCompleted = Task::join('task_users', 'task_users.task_id', '=', 'tasks.id')
            ->where('task_users.user_id', $id)
            ->where('tasks.board_column_id', $taskBoardColumn->id)
            ->count();

        $hoursLogged = ProjectTimeLog::where('user_id', $id)->sum('total_minutes');
        $breakMinutes = ProjectTimeLogBreak::userBreakMinutes($id);

        $timeLog = intdiv($hoursLogged - $breakMinutes, 60);

        $this->hoursLogged = $timeLog;

        $this->activities = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->get();

        $this->fromDate = Carbon::now()->timezone($this->global->timezone)->startOfMonth()->toDateString();
        $this->toDate = Carbon::now()->timezone($this->global->timezone)->toDateString();

        $tab = request('tab');

        switch ($tab) {
        case 'tickets':
            return $this->tickets();
        case 'projects':
            return $this->projects();

        case 'tasks':
            return $this->tasks();
        case 'leaves':
            return $this->leaves();
        case 'timelogs':
            return $this->timelogs();
        case 'documents':
            $this->view = 'employees.ajax.documents';
            break;
        case 'emergency-contacts':
            $this->view = 'employees.ajax.emergency-contacts';
            break;
        case 'leaves-quota':
            $this->leaveTypes = LeaveType::byUser($id);
            $this->leavesTakenByUser = Leave::byUserCount($id);
            $this->allowedLeaves = $this->employee->leaveTypes->sum('no_of_leaves');
            $this->employeeLeavesQuota = $this->employee->leaveTypes;
            $this->employeeLeavesQuotas = User::with('leaveTypes', 'leaveTypes.leaveType')->withoutGlobalScope('active')->findOrFail($id)->leaveTypes;
            $this->view = 'employees.ajax.leaves_quota';
                break;
        case 'shifts':
            abort_403(user()->permission('view_shift_roster') != 'all');
            $this->view = 'employees.ajax.shifts';
            break;
        case 'calcul':
            /*abort_403(user()->permission('manage_role_permission_setting') != 'all');

            $this->modulesData = Module::with('calcul')->withCount('customPermissions')->get();*/
            $this->view = 'paie.ajax.calcul';
            break;
        case 'avs':
            /*abort_403(user()->permission('manage_role_permission_setting') != 'all');

            $this->modulesData = Module::with('calcul')->withCount('customPermissions')->get();*/
            $this->listAVS = salaire_avance::where('user_id', $id)
            ->get();
            $this->view = 'paie.ajax.avs';
            break;

        default:
            $this->view = 'paie.ajax.profile';
            break;
        }

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();
            return Reply::dataOnly(['views' => $this->view,'status' => 'success','html' => $html, 'title' => $this->pageTitle]);
        }

        $this->activeTab = ($tab == '') ? 'profile' : $tab;

        return view('paie.show', $this->data);

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

    public function generatePDF(Request $request)
    {
      
      $refBulletin=$request->ref;
      $bulletin = DB::table('salaire_bulletins')
        ->join('employee_details', 'employee_details.user_id', '=', 'salaire_bulletins.user_id')
        ->join('users', 'employee_details.user_id', '=', 'users.id')
        ->join('designations', 'employee_details.designation_id', '=', 'designations.id')
        ->join('teams', 'employee_details.department_id', '=', 'teams.id')
        ->join('salaire_categoriels', 'salaire_bulletins.categorie_id', '=', 'salaire_categoriels.id')
        ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation')
        ->where('salaire_bulletins.id', $refBulletin)
        ->first();

      $prime = DB::table('salaire_bulletin_primes')
        ->join('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_primes.bulletin_id')
        ->join('salaire_prime_indemnites', 'salaire_prime_indemnites.id', '=', 'salaire_bulletin_primes.prime_id')
        ->select('salaire_bulletin_primes.*', 'libelle_prime', 'type_prime')
        ->where('salaire_bulletin_primes.bulletin_id', $refBulletin)
        ->get();

      $taxe = DB::table('salaire_bulletin_taxes')
        ->join('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_taxes.bulletin_id')
        ->join('salaire_taxes', 'salaire_taxes.id', '=', 'salaire_bulletin_taxes.taxe_id')
        ->select('salaire_bulletin_taxes.*', 'libelle_taxe')
        ->where('salaire_bulletin_taxes.bulletin_id', $refBulletin)
        ->get();

            
      $data = [
        'title' => 'Bulletin de paie',
        'date' => date('m/d/Y'),
        'logo'  => global_setting()->logo_url,
        'bulletin' => $bulletin,
        'prime' => $prime,
        'taxe' => $taxe
      ];
        //dd($data['title']);
      //$pdf = PDF::loadView('paie.bulletin_paie', ['data' => $data] );
        //return $pdf->download('bulletin_paie.pdf');
      
      return PDF::loadView('paie.bulletin_paie', compact('data'))
            ->setPaper('a4')
            ->setWarnings(false)
            ->stream('bulletin_paie.pdf');
    }

    
    public function calcul(Request $request)
    {

        $user_id=$request->employee;
        $this->employee=$employee = EmployeeDetails::where('user_id', '=', $user_id)->first();
        if ($employee) {
            $this->indemniteLicenciement=0;
            $this->salaire_preavis = 0;
            $this->indemnite_de_fin_de_contrat=0;
            $this->solde_tout_compte=0;
            $this->gratification=0;
             
            $this->annual_leave=$annual_leave = annualLeave::where('user_id', $user_id)->orderBy('leave_date_fin', 'desc')->first();
            $salaire = DB::table('salaire_bulletins')->where('user_id', '=', $user_id);

            $debut_contrat = $employee->joining_date; // date de début de contrat au format Y-m-d
            $fin_contrat = $employee->date_end_contrat; // date de fin de contrat au format Y-m-d
            $salaire_categoriel = $employee->salaire_categoriel; // salaire categoriel en euros
            if ($annual_leave) {
                $derniers_conges_pris = $annual_leave->leave_date_fin; // date de retours des derniers congés pris au format Y-m-d
            }else{
                //s'il n'a jamais pris de congé consiéré la date de debut de contrat
                $derniers_conges_pris = $debut_contrat;
            }
            
            $nb_mois_travailles_apres_derniers_conges = (int)(date_diff(date_create($derniers_conges_pris), date_create($fin_contrat)))->format('%m');
            
            $annees_travaillees = (int)(date_diff(date_create($debut_contrat), date_create($fin_contrat)))->format('%y'); // nombre d'années travaillées

            // Calcul de l'Allocation de congé
            $nb_jours_ouvres_conges = (int) (2.2 * $nb_mois_travailles_apres_derniers_conges * 1.25);

            $salaire_brut_imposable = $salaire->sum('total_imposable'); // salaire brut imposable mensuel en euros
            $salaire_journalier = $salaire_brut_imposable / 30;
            $this->indemnite_conge = $indemnite_conge = round($salaire_journalier * $nb_jours_ouvres_conges);

            $yearMonth = date('Y-m', strtotime($fin_contrat));// Extraire le mois et l'année de la date donnée
            // salaire du mois de fin de contrat
            $salaire_du_mois = $salaire->where(DB::raw('DATE_FORMAT(salaire_fin, "%Y-%m")'), '=', $yearMonth)->first();
            if ($salaire_du_mois) {
                $this->salaire_net_du_mois = $salaire_net_du_mois=$salaire_du_mois->net_a_payer;
            }else{
                $this->salaire_net_du_mois = $salaire_net_du_mois=0;
            } 

            $gratification =0;
            $gratif_type=global_setting()->frequence_gratification;
            if ($gratif_type == 'an') {
                $dateEnd = Carbon::parse($fin_contrat); // Remplacez 'Y-m-d' par la date souhaitée au format Y-m-d
                // Calcul du nombre de mois total du début de l'année jusqu'à la date donnée
                $debut_annee = Carbon::createFromDate($dateEnd->year, 1, 1);
                $nb_mois_travailles = $debut_annee->diffInMonths($dateEnd);
                // Calcul de la gratification au prorata
                if ($nb_mois_travailles >= 12) {
                    $gratification = $salaire_categoriel * 0.75;
                } else {
                    $gratification = $salaire_categoriel * 0.75 * $nb_mois_travailles / 12;
                }
            }
            if ($employee->motif_end_contrat=="demission") {

                $solde_tout_compte = $indemnite_conge + $salaire_net_du_mois + $gratification;

            }elseif ($employee->motif_end_contrat=="licenciement"){

                // Calcul de l'indemnité de licenciement
                $nbAnneesTravaillees = (int)(date_diff(date_create($debut_contrat), date_create($fin_contrat)))->format('%y');
                $taux = 0;
                if ($nbAnneesTravaillees < 1 ) {
                    $taux = 0;
                } elseif ($nbAnneesTravaillees <= 5 ) {
                    $taux = 0.3;
                } elseif ($nbAnneesTravaillees <= 10) {
                    $taux = 0.35;
                }else{
                    $taux = 0.4;
                }
                
                $nbSalaires = DB::table('salaire_bulletins')
                    ->where('user_id', $user_id)
                    ->count();

                if ($nbSalaires < 12) {
                    // Si l'utilisateur a moins de 12 salaires, on calcule la moyenne sur le nombre de salaires disponibles
                    $salaireMoyenMensuel = DB::table('salaire_bulletins')
                        ->where('user_id', $user_id)
                        ->pluck('total_brut')
                        ->average();
                }else{
                    $salaireMoyenMensuel = DB::table('salaire_bulletins')
                        ->where('user_id', $user_id)
                        ->orderBy('salaire_fin', 'desc')
                        ->take(12)
                        ->pluck('total_brut')
                        ->average();
                }

                // Le salaire moyen mensuel est arrondi à deux décimales
                $salaireMoyenMensuel = round($salaireMoyenMensuel);
                $this->indemniteLicenciement=$indemniteLicenciement = $taux * ($salaireMoyenMensuel * $nbAnneesTravaillees);
                if ($nbAnneesTravaillees > 5) {
                    $this->indemniteLicenciement=$indemniteLicenciement = (0.3 * ($salaireMoyenMensuel * 5)) + (0.35 * ($salaireMoyenMensuel * ($nbAnneesTravaillees - 5)));
                }
                $this->salaire_preavis = $salaire_preavis = $salaire_net_du_mois;

                $solde_tout_compte=$indemnite_conge+ $indemniteLicenciement + $salaire_preavis + $gratification;

            }elseif($employee->motif_end_contrat=="fin_contrat"){
                $this->indemnite_de_fin_de_contrat=round($indemnite_de_fin_de_contrat=0.03*$salaire_brut_imposable);
                $solde_tout_compte = $salaire_net_du_mois + $indemnite_de_fin_de_contrat + $gratification;
            }
            $this->solde_tout_compte=round($solde_tout_compte);
            $this->gratification=round($gratification);
            
            $this->fin_contrat = $fin_contrat->format('d-m-Y');
            return Reply::successWithData('Solde de tout compte calculé avec succès', ['data' => $this->data]);
        }
    }
}
