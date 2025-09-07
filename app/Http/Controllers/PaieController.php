<?php

namespace App\Http\Controllers;
use App\DataTables\PaieEmployeesDataTable;
use App\Events\BulletinSalaireEvent;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Requests\salaireBulletin\StoreRequest;
use App\Http\Requests\salaireBulletin\UpdateRequest;
use App\Models\annualLeave;
use App\Models\BaseModel;
use App\Models\Designation;
use App\Models\EmployeeDetails;
use App\Models\niveau_etude;
use App\Models\Role;
use App\Models\salaire_avance;
use App\Models\salaire_bulletin;
use App\Models\salaire_bulletin_prime;
use App\Models\salaire_bulletin_taxe;
use App\Models\salaire_categoriel;
use App\Models\salaire_primeIndemnite;
use App\Models\salaire_taxe;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use PDF;
use Response;

class PaieController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.paie';
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
    public function index(PaieEmployeesDataTable $dataTable)
    {
    
        if (!request()->ajax()) {
            $this->employees = User::allEmployees();
            $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
            $this->totalEmployees = count($this->employees);
            $this->designations = Designation::allDesignations();
            $this->roles = Role::where('name', '<>', 'client')
                ->orderBy('id', 'asc')->get();

        }
        return $dataTable->render('paie.index', $this->data);
    }


    public function create()
    {
        $viewPermission = user()->permission('add_pay');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']) && empty(array_intersect(['RH', 'admin'], user_roles())));
        $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        return view('salaireCategoriel.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        
        DB::beginTransaction();
        try {
            $bulletin = new salaire_bulletin();
            $bulletin->user_id = $request->user_id;

            //return (Carbon::createFromFormat($this->global->date_format, $request->dateDebutSalaire)->format('Y-m-d') );
            //return Reply::successWithData('test', ['data' => $request->dateDebutSalaire]);
            $bulletin->salaire_debut =$request->dateDebutSalaire;
            $bulletin->salaire_fin = $request->dateFinSalaire;
            $bulletin->categorie_id = $request->idCategorie;
            $bulletin->salaire_base = $request->salaireCategorie;
            $bulletin->part_IGR = $request->partIGR;
            $bulletin->anciennete_mois = $request->MonthAncien;
            $bulletin->anciennete_detail = $request->ancienneteText;
            $bulletin->avs = $request->avs;
            $bulletin->autre_retenu = $request->autre_retenu;
            $bulletin->salaire_base = $request->salaire_base;
            $bulletin->total_brut = $request->total_brut;
            $bulletin->total_brut_general = $request->total_brut_general;
            $bulletin->total_imposable = $request->total_imposable;
            $bulletin->total_non_imposable = $request->total_non_imposable;
            $bulletin->total_retenu_salarial = $request->total_retenu_salarial;
            $bulletin->total_retenu_patronal = $request->total_retenu_patronal;
            $bulletin->net_a_payer = $request->net_a_payer;
            $bulletin->conges_mensuel_acquis = $request->conges_mensuel_acquis;

            $TablePrime=json_decode($request->TablePrime);
            $TableTaxe=json_decode($request->TableTaxe);
            $bulletin->save();
            if ($bulletin->id) {
              foreach ($TablePrime as $keyPrime) {
                $prime = new salaire_bulletin_prime();
                $prime->bulletin_id=$bulletin->id;
                $prime->prime_id=$keyPrime->id;
                $prime->base_prime=$keyPrime->base;
                $prime->taux=$keyPrime->taux;
                $prime->gain=$keyPrime->gain;
                $prime->save();
              }
              foreach ($TableTaxe as $keyTaxe) {
                $taxe = new salaire_bulletin_taxe();
                $taxe->bulletin_id=$bulletin->id;
                $taxe->taxe_id=$keyTaxe->id;
                $taxe->base_taxe=$keyTaxe->base;
                $taxe->taux_salarial=$keyTaxe->taux_salarial;
                $taxe->retenu_salarial=$keyTaxe->retenu_salarial;
                $taxe->taux_patronal=$keyTaxe->taux_patronal;
                $taxe->retenu_patronal=$keyTaxe->retenu_patronal;
                $taxe->save();
              }
                if ($request->annualLeaveID) {
                    $annualLeave = annualLeave::find($request->annualLeaveID);
                    if ($annualLeave) {
                        $annualLeave->allocationUse = 1 ;
                        $annualLeave->save();
                    }
                }
                
                

              $employee = EmployeeDetails::where('user_id', '=', $request->user_id)->first();
              $employee->nbre_jour_conges_dus = $employee->nbre_jour_conges_dus+ $request->conges_mensuel_acquis ;
              $employee->save();

            }
            $mntRembourse=$request->avs;
            if ($mntRembourse>0) {
                $avs = salaire_avance::where('user_id', $request->user_id)->where('reste_avs', '>', 0)->orderBy('id')->get();
                foreach($avs as $row){
                  if ($mntRembourse>=$row->reste_avs) {
                    $totalRembourse=$row->reste_avs+$row->rembourse_avs;
                    $group = salaire_avance::find($row->id);
                    $group->rembourse_avs = $totalRembourse;
                    $group->reste_avs = 0;
                    $group->save();
                    $mntRembourse=$mntRembourse-$row->reste_avs;
                  }else{
                    $totalRembourse=$mntRembourse+$row->rembourse_avs;
                    $reste_avs=$row->reste_avs-$mntRembourse;
                    $group = salaire_avance::find($row->id);
                    $group->rembourse_avs = $totalRembourse;
                    $group->reste_avs = $reste_avs;
                    $group->save();
                  }
                }
            //return $group;
            }

            $salaireCategoriel = salaire_bulletin::allSalaireBulletin();
            $options = BaseModel::options($salaireCategoriel, $bulletin);

            // Commit Transaction
            DB::commit();


            // Send notification to user
            $notifyUser = User::withoutGlobalScope('active')->findOrFail($request->user_id);
            // Déclenchement d'un événement pour les observateurs
            event(new BulletinSalaireEvent($bulletin, $notifyUser));



            return Reply::successWithData('Bulletin de Salaire édité avec succès', ['data' => $bulletin->id]);
        } catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();
            // Log::info($e);
            //return Reply::error($e);
            return Reply::error('Une erreur s\'est produite lors de l\'édition du bulletin. Veuillez réessayer');
        }
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function update(UpdateRequest $request, $id)
    {
        $viewPermission = user()->permission('edit_pay');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));

        $group = salaire_categoriel::find($id);
        $group->categorie_sc = strip_tags($request->categorie_sc);
        $group->salaire_sc = strip_tags($request->salaire_sc);
        //return $group;
        $group->save();

        $salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $options = BaseModel::options($salaireCategoriel);

        return Reply::successWithData(__('messages.updatedSuccessfully'), ['data' => $options]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $viewPermission = user()->permission('delete_pay');
        abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));
        DB::beginTransaction();
        try {
            $primes=salaire_bulletin_prime::where('bulletin_id', $id)->get();
            $taxes=salaire_bulletin_taxe::where('bulletin_id', $id)->get();
            foreach($primes as $prime){
                salaire_bulletin_prime::destroy($prime->id);
            }
            foreach($taxes as $taxe){
                salaire_bulletin_taxe::destroy($taxe->id);
            }
            $salaire_bulletin=salaire_bulletin::where('id', $id)->first();

            if ($salaire_bulletin) {
                $employee = EmployeeDetails::where('user_id', '=', $salaire_bulletin->user_id)->first();
                $employee->nbre_jour_conges_dus = $employee->nbre_jour_conges_dus - $salaire_bulletin->conges_mensuel_acquis ;
                $employee->save();
            }

            salaire_bulletin::destroy($id);
            // Commit Transaction
            DB::commit();
            return Reply::success(__('messages.deleteSuccess'));
        } catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();
            //return Reply::error($e);
            return Reply::error('Une erreur s\'est produite lors de l\'édition du bulletin. Veuillez réessayer');
        }

        $salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $options = BaseModel::options($salaireCategoriel);

        
    }

    public function show($id)
    {


        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes', 'country', 'emergencyContacts'])->withoutGlobalScope('active')->with('employee')->withCount('member', 'openTasks')->findOrFail($id);
        $this->salaireAVS =  DB::table('salaire_avances')
          ->select(DB::raw('SUM(reste_avs) as resteAVS'))
          ->where('user_id', $id)
          ->first();
        //salaire_avance::where('user_id', $id)->get();
        $this->viewPermission = user()->permission('view_employees');
        $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $this->salairePrime = salaire_primeIndemnite::allsalairePrime();

        $this->salaireTaxe = salaire_taxe::allsalaireTaxe();
        //dd($this->salaireTaxe);
        $id_superieur=$this->employee->employeeDetail->id_superieur;
        $id_niveau_etude=$this->employee->employeeDetail->id_niveau_etude;
        $salaire_categoriel=$this->employee->employeeDetail->salaire_categoriel;
        $this->superieur = User::allEmployees()->where('id', $id_superieur)->first();
        $this->niveau = niveau_etude::where('id', $id_niveau_etude)->first();
        $this->salaire_categoriel = salaire_categoriel::where('id', $salaire_categoriel)->first();

        $dateEmbauche = $this->employee->employeeDetail->joining_date;
        // Obtenir la date actuelle
        $dateActuelle = date('Y-m-d');

        // Calculer la durée d'ancienneté
        $diff = date_diff(date_create($dateEmbauche), date_create($dateActuelle));
        $annees = $diff->format('%y');
        $mois = $diff->format('%m');
        $this->totalMois= $annees*12 + $mois;
        // Afficher la durée d'ancienneté en années et mois
        $this->anciennete= $annees . " ans " . $mois . " mois";

        $this->primeAncienete=0;
        if ($this->salaire_categoriel) {
            $montant_salaire_cat=$this->salaire_categoriel->salaire_sc;
            if ($annees>=2) {
               $this->primeAncienete=round($annees*$montant_salaire_cat/100);
            }
        }
        //dd($this->employee);

        $this->DateStart = Carbon::now()->timezone($this->global->timezone)->startOfMonth()->toDateString();
        $this->DateEnd = Carbon::now()->timezone($this->global->timezone)->endOfMonth()->toDateString();
        //dd($this->DateEnd);
        //dd($this->anciennete);
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

        $tab = request('tab');

        switch ($tab) {
        
            case 'liste_paie':
                $this->bulletin = DB::table('salaire_bulletins')
                ->join('employee_details', 'employee_details.user_id', '=', 'salaire_bulletins.user_id')
                ->join('users', 'employee_details.user_id', '=', 'users.id')
                ->join('designations', 'employee_details.designation_id', '=', 'designations.id')
                ->join('teams', 'employee_details.department_id', '=', 'teams.id')
                ->join('salaire_categoriels', 'salaire_bulletins.categorie_id', '=', 'salaire_categoriels.id')
                ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation', 'nbre_jour_conges_pris', 'nbre_jour_conges_dus')
                ->where('salaire_bulletins.user_id', $id)
                ->orderBy('salaire_debut', 'DESC')
                ->get();
                 //dd($this->bulletin);
                $this->view = 'paie.ajax.liste_paie';
                break;
            case 'calcul':
                $this->allocationConge = annualLeave::where('user_id', $id)
                    ->where('allocationUse', 0)
                    ->where('status', 'approved')
                    ->whereMonth('leave_date_debut', Carbon::now()->month)
                    ->whereYear('leave_date_debut', Carbon::now()->year)
                    ->first();
                //dd($this->allocationConge);
                $bulletin = DB::table('salaire_bulletins')
                    ->join('employee_details', 'employee_details.user_id', '=', 'salaire_bulletins.user_id')
                    ->join('users', 'employee_details.user_id', '=', 'users.id')
                    ->join('designations', 'employee_details.designation_id', '=', 'designations.id')
                    ->join('teams', 'employee_details.department_id', '=', 'teams.id')
                    ->join('salaire_categoriels', 'salaire_bulletins.categorie_id', '=', 'salaire_categoriels.id')
                    ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation', 'nbre_jour_conges_pris', 'nbre_jour_conges_dus')
                    ->where('salaire_bulletins.user_id', $id)
                    ->orderBy('salaire_debut', 'DESC')
                    ->first();
    
                if ($bulletin) {
                    
                  /* $this->salairePrime = DB::table('salaire_prime_indemnites')
                    ->leftJoin('salaire_bulletin_primes', 'salaire_bulletin_primes.prime_id', '=', 'salaire_prime_indemnites.id')
                    ->leftJoin('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_primes.bulletin_id')
                    ->select('salaire_bulletin_primes.gain', 'salaire_bulletin_primes.base_prime', 'salaire_prime_indemnites.libelle_prime', 'salaire_prime_indemnites.type_prime', 'salaire_bulletin_primes.taux as nbreJTaux', 'salaire_prime_indemnites.id as id')
                    ->where('salaire_bulletin_primes.bulletin_id', $bulletin->id)
                    ->orWhereNull('salaire_bulletin_primes.bulletin_id')
                    ->get();*/
                    
                    $this->salairePrime = DB::table('salaire_prime_indemnites')
                    ->leftJoin('salaire_bulletin_primes', function($join) use ($bulletin) {
                        $join->on('salaire_bulletin_primes.prime_id', '=', 'salaire_prime_indemnites.id')
                             ->where('salaire_bulletin_primes.bulletin_id', '=', $bulletin->id);
                    })
                    ->select(
                        'salaire_bulletin_primes.gain',
                        'salaire_bulletin_primes.base_prime',
                        'salaire_prime_indemnites.libelle_prime',
                        'salaire_prime_indemnites.type_prime',
                        'salaire_bulletin_primes.taux as nbreJTaux',
                        'salaire_prime_indemnites.id as id'
                    )
                    ->get();



                        
                    //dd($this->salairePrime);

                    /*$this->salaireTaxe = DB::table('salaire_taxes')
                        ->leftJoin('salaire_bulletin_taxes', 'salaire_taxes.id', '=', 'salaire_bulletin_taxes.taxe_id')
                        ->leftJoin('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_taxes.bulletin_id')
                        ->select('salaire_taxes.id as id', 'code', 'methodeCalcul', 'baseCalcule', 'TypeApplicable', 'libelle_taxe', 'type_obligation', 'base_taxe', 'salaire_taxes.taux_salarial', 'retenu_salarial', 'salaire_taxes.taux_patronal', 'retenu_patronal')
                        ->where('salaire_bulletin_taxes.bulletin_id', $bulletin->id)
                        ->orWhereNull('salaire_bulletin_taxes.bulletin_id')
                        ->get();*/
                    $this->salaireTaxe = DB::table('salaire_taxes')
                        ->leftJoin('salaire_bulletin_taxes', function($join) use ($bulletin) {
                            $join->on('salaire_taxes.id', '=', 'salaire_bulletin_taxes.taxe_id')
                                 ->where('salaire_bulletin_taxes.bulletin_id', '=', $bulletin->id);
                        })
                        ->leftJoin('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_taxes.bulletin_id')
                        ->select(
                            'salaire_taxes.id as id',
                            'code',
                            'methodeCalcul',
                            'baseCalcule',
                            'TypeApplicable',
                            'libelle_taxe',
                            'type_obligation',
                            'base_taxe',
                            'salaire_taxes.taux_salarial',
                            'retenu_salarial',
                            'salaire_taxes.taux_patronal',
                            'retenu_patronal'
                        )
                        ->get();


                }
                
                //dd($this->salaireTaxe);
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
        ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation', 'nbre_jour_conges_pris', 'nbre_jour_conges_dus')
        ->where('salaire_bulletins.id', $refBulletin)
        ->first();
        if ($bulletin) {
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

            $date = $bulletin->salaire_fin;
            $periode=$this->afficherBulletinPaie($date);     
            $data = [
                'title' => 'Bulletin de paie',
                'date' => date('m/d/Y'),
                'logo'  => parse_url(global_setting()->logo_url, PHP_URL_PATH),
                'bulletin' => $bulletin,
                'prime' => $prime,
                'taxe' => $taxe,
                'periode' => $periode
            ];
            $fileName = 'bulletin-paie-' . $bulletin->employee_id . '-' . date('mdYHis');

            return PDF::loadView('paie.bulletin_paie', compact('data'))
                ->setPaper('a4')
                ->setWarnings(false)
                ->stream($fileName . '.pdf');
        }else{
            abort(404, 'La page que vous cherchez n\'existe pas.');
        }
    }
    public function downloadPDF(Request $request)
    {
      
      //dd(Auth::user()->id);
      
      $refBulletin=$request->ref;
      
        $bulletin = DB::table('salaire_bulletins')
        ->join('employee_details', 'employee_details.user_id', '=', 'salaire_bulletins.user_id')
        ->join('users', 'employee_details.user_id', '=', 'users.id')
        ->join('designations', 'employee_details.designation_id', '=', 'designations.id')
        ->join('teams', 'employee_details.department_id', '=', 'teams.id')
        ->join('salaire_categoriels', 'salaire_bulletins.categorie_id', '=', 'salaire_categoriels.id')
        ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation', 'nbre_jour_conges_pris', 'nbre_jour_conges_dus')
        ->where('salaire_bulletins.id', '=', $refBulletin)
        ->first();

        if ($bulletin) {
            // code...
            if (Auth::user()->id==$bulletin->user_id) {
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
                    'date' => date('d/m/Y'),
                    'logo'  => global_setting()->logo_url,
                    'bulletin' => $bulletin,
                    'prime' => $prime,
                    'taxe' => $taxe
                ];

                $fileName='bulletin-paie-'.$bulletin->employee_id.'-'.date('mdYHis');
                return PDF::loadView('paie.bulletin_paie', compact('data'))
                    ->setPaper('a4')
                    ->setWarnings(false)
                    ->stream($fileName.'.pdf');
            }else{
                abort(404, 'La page que vous cherchez n\'existe pas.');
                //return Reply::error('Vous n\'avez pas accès à cette donnée');


            }
        }else{
            abort(404, 'La page que vous cherchez n\'existe pas.');
        }
    }
    
    function afficherBulletinPaie($date)
    {
        // Convertir la date en objet Carbon pour faciliter la manipulation
        $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $date);

        // Obtenir le mois en lettres et traduit en function du fichier de langue
        
        $moisEnLettres = trans('app.' . strtolower($dateObj->format('F')));

        // Obtenir l'année
        $annee = $dateObj->format('Y');

        // Afficher le résultat
        return $moisEnLettres." ".$annee;
    }

    

    public function Anciennete(Request $request)
    {
        $dateEmbauche = $request->dateEmbauche;
        $dateActuelle = $request->dateActuelle;
        $montant_salaire_cat=$request->salaire_categoriel;
        // Calculer la durée d'ancienneté
        $diff = date_diff(date_create($dateEmbauche), date_create($dateActuelle));
        $annees = $diff->format('%y');
        $mois = $diff->format('%m');
        $this->primeAncienete=0;
        if ($annees>=2) {
           $this->primeAncienete=round($annees*$montant_salaire_cat/100);
        }
        // Afficher la durée d'ancienneté en années et mois
        $this->totalMois= $annees*12 + $mois;
        $this->anciennete= $annees . " ans " . $mois . " mois";
        $this->status = 'success';
        return $this->data;
        //return Reply::successWithData('Ancienneté', ['data' => $anciennete]);
    }

    public function Gratification(Request $request)
    {
        $montant_salaire_cat=$request->salaire_categoriel;
        $dateFin=$request->dateFin;
        $anciennete = $request->anciennete;
        $gratif = 0;
        $gratif_type=global_setting()->frequence_gratification;
        //return $gratif_type;
        // Calcul de la gratification
        if ($gratif_type == 'mois') {
            if ($anciennete > 12) {
                $gratif = ($montant_salaire_cat * 0.75) / 12;
            } else {
                $gratif = 0;
            }
        } elseif ($gratif_type == 'an') {
            if(date('m', strtotime($dateFin)) === '12') {

                if ($anciennete > 12) {
                    $gratif = $montant_salaire_cat * 0.75;
                } else {
                    $gratif = $montant_salaire_cat * 0.75 * $anciennete / 12;
                }
            }
        }

        $this->gratification= round($gratif);
        $this->status = 'success';



        return $this->data;
        //return Reply::successWithData('Ancienneté', ['data' => $anciennete]);
    }

    
    
    public function masse_salariale(Request $request)
    {
        
        // $viewPermission = user()->permission('view_registre_paiement');
        // abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']) && empty(array_intersect(['RH', 'admin'], user_roles())));
       $this->listMasseSalariale = DB::table('salaire_bulletins')
        ->select(DB::raw('DATE_FORMAT(salaire_fin, "%m") as mois'),
          DB::raw('DATE_FORMAT(salaire_fin, "%Y") as annee'),
          DB::raw('SUM(net_a_payer) as totalNet'))
        ->groupBy('mois', 'annee')
        ->orderBy('annee', 'desc')
        ->orderBy('mois', 'desc')
        ->get();
        return view('paie.ajax.masse_salariale', $this->data);
    }
}
