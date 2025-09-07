<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helper\Reply;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\salaireAVS\StoreRequest;
use App\Http\Requests\salaireAVS\UpdateRequest;
use App\Models\BaseModel;
use App\Models\salaire_avance;
use App\Models\EmployeeDetails;
use App\Models\mode_reglement;
use App\Models\Team;
use App\DataTables\AvanceDataTable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\operation;
use App\Models\budget_categorie;
use App\Models\exercice_comptable;
use App\Models\operation_type;
use App\Models\budget;
use Auth;
use Illuminate\Support\Facades\Validator;

class salaireAVSController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.salaireAVS';
        $this->middleware('auth');
        /*$this->middleware(function ($request, $next) {
            abort_403(!in_array('paie', $this->user->modules));
            return $next($request);
        });*/
    }

    public function create(Request $request)
    {
        //return redirect()->route('dashboard');
        $this->addPermission = user()->permission('add_pay');
        // abort_403(!in_array($this->addPermission, ['all', 'added']));
        $this->employees = User::allEmployees();
        $this->user_id=$request->id;
        $this->salaireAVS = salaire_avance::all();
        $this->mode_reglement=mode_reglement::all();
        $this->teams = Team::all();
        $this->budget_categories=budget_categorie::all();
        $this->operation_types=operation_type::all();
        $this->budget_categories=budget_categorie::all();

        $this->exerciceActif=exercice_comptable::where('code_statut', 1)->firstOrFail();
       $this->view = 'salaireAVS.ajax.create';
        return view('salaireAVS.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    /**
     * @param AvanceDataTable $dataTable
     * @return mixed|void
     */
    public function index(AvanceDataTable $dataTable)
    {
        $this->employees = User::allEmployees();
        return $dataTable->render('paie.ajax.list_avs', $this->data);
    }
    public function store(Request $request)
    {
        if ($request->operation_budget=="oui") {
            $validator = Validator::make($request->all(), [
                'operation_type' => 'required',
                'department' => 'required',
                'budget_id' => 'required',
                'montantEmprunt' => 'required',
                'motif' => 'required',
                'dateEmprunt' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return Reply::formErrors($validator);
            }

            // faire un get sur le budget puis enregistrer
            $budget=budget::where('id', $request->budget_id)->first();
            //return $budget;
        }else{
            // créer le budget puis poursuivre
            $validator = Validator::make($request->all(), [
                'operation_type' => 'required',
                'budget_categorie_id' => 'required',
                'libelle_budget' => 'required',
                'exercice_comptable_id' => 'required',
                'planComptable' => 'required',
                'type_exploitation' => 'required',
                'frais_generaux' => 'required',
                'obligation_fiscale' => 'required',
                'department' => 'required',
                'budget_id' => 'required',
                'montantEmprunt' => 'required',
                'motif' => 'required',
                'dateEmprunt' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return Reply::formErrors($validator);
            }

            $groupBudget = new budget();
            $groupBudget->plan_comptable_id = $request->planComptable;
            $groupBudget->exercice_comptable_id = $request->exercice_comptable_id;
            $groupBudget->operation_type_id = $request->operation_type;
            $groupBudget->type_exploitation = $request->type_exploitation;
            $groupBudget->budget_categorie_id = $request->budget_categorie_id;
            $groupBudget->frais_generaux = $request->frais_generaux;
            $groupBudget->obligation_fiscale = $request->obligation_fiscale;
            //$groupBudget->budget_annuel = 0;
            //$groupBudget->budget_mensuel = 0;
            $groupBudget->libelle_budget = $request->libelle_budget;
            $groupBudget->description_budget = $request->description_budget;
            //$groupBudget->montant_ecart = 0;
            $groupBudget->budget_operation = 'hors_budget';

            $groupBudget->save();
            $budget=$groupBudget;


        }
        $tiers = User::TiersEmploye()->first();
        //orWhere
        //return($tiers);
        $group = new salaire_avance();
        $montantEmprunt=str_replace(' ', '', $request->montantEmprunt);

        $group->user_id = $request->user_id;
        $group->montant_avs = $montantEmprunt;
        $group->rembourse_avs = 0;
        $group->reste_avs = $montantEmprunt;
        $group->motif_avs = $request->motif;
        $group->date_avs = Carbon::createFromFormat($this->global->date_format, $request->dateEmprunt)->format('Y-m-d');

        $group->save();
        //Ajouter dans la table opération
        $operation = new operation();

        if($budget){
            if ($budget->type_exploitation=='charge'||$budget->type_exploitation=='investissement' || $budget->type_exploitation=='chargesHAO') {
                $montantEmprunt=$montantEmprunt*(-1);
                $operation->montant_depense = round($montantEmprunt, 2);
                $operation->montant_depense_HT = round($montantEmprunt, 2);
                $operation->montant_recette = 0;
                $operation->montant_recette_HT = 0;

            }else{
                $operation->montant_recette = round($montantEmprunt, 2);
                $operation->montant_recette_HT = round($montantEmprunt, 2);
                $operation->montant_depense = 0;
                $operation->montant_depense_HT = 0;
            }
        }


        $operation->budget_id = $budget->id;
        $operation->client_id = $tiers ? $tiers->client_id : null;
        $operation->mode_reglement_id = $request->mode_reglement_id;
        $operation->salaire_avance_id = $group->id;
        $operation->montant_operation_HT = round($montantEmprunt, 2) ;
        $operation->net_a_payer = round($montantEmprunt, 2) ;
        $operation->montant_TTC = round($montantEmprunt, 2);
        $operation->department_id = $request->department;
        $operation->compte_associe = $tiers ? $tiers->compte_collectif : '422';
        $operation->description_operation = $request->motif;
        $operation->date_operation = Carbon::createFromFormat($this->global->date_format, $request->dateEmprunt)->format('Y-m-d');
        $operation->save();

        $salaireAVS = salaire_avance::all();

        $options = BaseModel::options($salaireAVS, $group);

        return Reply::successWithData('Avance/Acompte Ajouté avec succès', ['data' => $options]);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */

    public function show(Request $request)
    {
        $this->employees = User::allEmployees();
        $this->user_id=$request->id;
        $this->salaireAVS = salaire_avance::where('id', $request->id)->first();
        return view('salaireAVS.edit', $this->data);
    }

    public function edit(Request $request, $id)
    {
        $this->addPermission = user()->permission('add_payments');
        abort_403(!in_array($this->addPermission, ['all', 'added']));
        $this->employees = User::allEmployees();
        $this->user_id=$request->user_id;
        //dd($this->user_id);
        
        $this->mode_reglement=mode_reglement::all();
        $this->teams = Team::all();
        $this->budget_categories=budget_categorie::all();
        $this->operation_types=operation_type::all();
        $this->budget_categories=budget_categorie::all();
        $this->salaireAVS = salaire_avance::findOrFail($id);

        $this->operations =$operations= operation::join('budgets', 'budgets.id', '=', 'operations.budget_id')
            ->leftJoin('plan_comptables', 'plan_comptables.id', '=', 'budgets.plan_comptable_id')
            ->leftJoin('compte_majeurs', 'compte_majeurs.id', '=', 'plan_comptables.compte_majeur_id')
            ->join('compte_generals', 'compte_generals.id', '=', 'compte_majeurs.compte_general_id')
            ->leftJoin('operation_types', 'operation_types.id', '=', 'budgets.operation_type_id')
            ->leftJoin('mode_reglements', 'mode_reglements.id', '=', 'operations.mode_reglement_id')
            ->select('operations.*','libelle_operation_type', 'operation_types.id as operation_type_id', 'operation_types.compte_general_id' )
            ->where('salaire_avance_id', $id)
            ->firstOrFail();

        $this->budgets = budget::leftJoin('plan_comptables', 'plan_comptables.id', '=', 'budgets.plan_comptable_id')
            ->join('operation_types', 'operation_types.id', '=', 'budgets.operation_type_id')


            ->select('budgets.*','libelle_operation_type')
            ->findOrFail($operations->budget_id);

        //dd($this->budgets);

        $this->exerciceActif=exercice_comptable::where('code_statut', 1)->firstOrFail();
        $this->view = 'salaireAVS.ajax.edit';
        return view('salaireAVS.create', $this->data);
    }

    public function update(Request $request)
    {
        if ($request->operation_budget=="oui") {
            $validator = Validator::make($request->all(), [
                'operation_type' => 'required',
                'department' => 'required',
                'budget_id' => 'required',
                'montantEmprunt' => 'required',
                'motif' => 'required',
                'dateEmprunt' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return Reply::formErrors($validator);
            }

            // faire un get sur le budget puis enregistrer
            $budget=budget::where('id', $request->budget_id)->first();
            //return $budget;
        }else{
            // créer le budget puis poursuivre
            $validator = Validator::make($request->all(), [
                'operation_type' => 'required',
                'budget_categorie_id' => 'required',
                'libelle_budget' => 'required',
                'exercice_comptable_id' => 'required',
                'planComptable' => 'required',
                'type_exploitation' => 'required',
                'frais_generaux' => 'required',
                'obligation_fiscale' => 'required',
                'department' => 'required',
                'budget_id' => 'required',
                'montantEmprunt' => 'required',
                'motif' => 'required',
                'dateEmprunt' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return Reply::formErrors($validator);
            }

            $groupBudget = budget::findOrFail($request->budget_id);
            $groupBudget->libelle_budget = strip_tags($request->libelle_budget);
            $groupBudget->type_exploitation = $request->type_exploitation;
            $groupBudget->budget_categorie_id = $request->budget_categorie_id;
            $groupBudget->frais_generaux = $request->frais_generaux;
            $groupBudget->obligation_fiscale = $request->obligation_fiscale;
            $groupBudget->description_budget = strip_tags($request->description_budget);
            $groupBudget->plan_comptable_id = $request->planComptable;
            $groupBudget->operation_type_id = $request->operation_type;
            //$groupBudget->montant_ecart = round($request->budget_annuel, 2);
            $groupBudget->budget_operation = 'hors_budget';

            $groupBudget->save();
            $budget=$groupBudget;
        }
        $tiers = User::TiersEmploye()->first();



        $id=$request->id_avs;
        $group = salaire_avance::find($id);
        $montantEmprunt=str_replace(' ', '', $request->montantEmprunt);
        $montantRestant=$montantEmprunt-$group->rembourse_avs;
        //$group->user_id = strip_tags($request->user_id);
        $group->montant_avs = strip_tags($montantEmprunt);
        //$group->rembourse_avs = 0;
        $group->reste_avs = strip_tags($montantRestant);
        $group->motif_avs = strip_tags($request->motif);
        $group->date_avs = Carbon::createFromFormat($this->global->date_format, $request->dateEmprunt)->format('Y-m-d');
        $group->save();

        $operation = operation::findOrFail($request->operation_id);
        if($budget){
            if ($budget->type_exploitation=='charge'||$budget->type_exploitation=='investissement' || $budget->type_exploitation=='chargesHAO') {
                $montantEmprunt=$montantEmprunt*(-1);
                $operation->montant_depense = round($montantEmprunt, 2);
                $operation->montant_depense_HT = round($montantEmprunt, 2);
                $operation->montant_recette = 0;
                $operation->montant_recette_HT = 0;

            }else{
                $montant_verse=$montant_verse;
                $operation->montant_recette = round($montantEmprunt, 2);
                $operation->montant_recette_HT = round($montantEmprunt, 2);
                $operation->montant_depense = 0;
                $operation->montant_depense_HT = 0;
            }
        }
        
        $operation->budget_id = $request->budget_id;;
        $operation->client_id = $tiers ? $tiers->client_id : null;
        $operation->mode_reglement_id = $request->mode_reglement_id;
        $operation->salaire_avance_id = $group->id;
        $operation->montant_operation_HT = round($montantEmprunt, 2) ;
        $operation->net_a_payer = round($montantEmprunt, 2) ;
        $operation->montant_TTC = round($montantEmprunt, 2);
        $operation->department_id = $request->department;
        $operation->compte_associe = $tiers ? $tiers->compte_collectif : '422';
        $operation->description_operation = $request->motif;
        $operation->date_operation = Carbon::createFromFormat($this->global->date_format, $request->dateEmprunt)->format('Y-m-d');
        $operation->save();
        
        $salaireAVS = salaire_avance::all();
        $options = BaseModel::options($salaireAVS);

        return Reply::successWithData(__('messages.updatedSuccessfully'), ['redirectUrl' => route('salaireAVS.index')]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //EmployeeDetails::where('designation_id', $id)->update(['designation_id' => null]);
        salaire_avance::destroy($id);
        $operation=operation::where('salaire_avance_id', $id)->firstOrFail();

        operation::destroy($operation->id);
        $salaireAVS = salaire_avance::all();
        $options = BaseModel::options($salaireAVS);

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }

    

    

}
