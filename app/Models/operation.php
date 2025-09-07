<?php

namespace App\Models;
use App\Traits\IconTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\budget;
use App\Models\encaissement;

class operation extends Model
{
    use HasFactory;
    use IconTrait;
    const FILE_PATH = 'operation_PJ';
    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = ['id'];
    protected $table = 'operations';
    protected $appends = ['doc_url', 'icon'];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDocUrlAttribute()
    {
        return asset_url_local_s3(Payment::FILE_PATH.'/'.$this->piece_jointe);
    }

    public static function getOperation()
    {
        return encaissement::leftJoin('operations',  'operations.id', '=', 'encaissements.operation_id')
            ->join('budgets', 'budgets.id', '=', 'operations.budget_id')
            ->join('plan_comptables', 'plan_comptables.id', '=', 'budgets.plan_comptable_id')
            ->join('compte_majeurs', 'compte_majeurs.id', '=', 'plan_comptables.compte_majeur_id')
            ->join('compte_generals', 'compte_generals.id', '=', 'compte_majeurs.compte_general_id')
            ->join('classe_plan_comptables', 'classe_plan_comptables.id', '=', 'compte_generals.classe_id')
            ->join('operation_types', 'operation_types.id', '=', 'budgets.operation_type_id')
            ->join('mode_reglements', 'mode_reglements.id', '=', 'operations.mode_reglement_id')
            ->leftJoin('exercice_comptables', 'exercice_comptables.id', '=', 'budgets.exercice_comptable_id')
            ->select('plan_comptable_id', 'encaissements.mode_reglement_id', 'montant_TTC', 'description_operation', 'encaissements.num_piece_regle', 'num_piece_justif', 'piece_jointe', 'montant_recette','montant_depense' , 'encaissements.montant_verse', 
                
                DB::raw('DATE_FORMAT(operations.date_operation, "%d-%m-%Y") as date_operation'), 
                DB::raw('DATE_FORMAT(encaissements.date_encaissement, "%d-%m-%Y") as date_encaissement'), 
                'libelle_compte', 'numero_compte', 'libelle_mode', 'libelle_operation_type', 'operations.id as operation_id', 'libelle_budget', 'compte_associe', 'numero_compte_general', 'libelle_compte_general', 'numero_compte_majeur', 'libelle_compte_majeur', 'operations.client_id',
                DB::raw('CASE WHEN montant_recette = 0 THEN encaissements.montant_verse ELSE NULL END AS depense'),
                DB::raw('CASE WHEN montant_depense = 0 THEN encaissements.montant_verse ELSE NULL END AS recette'))
            ->orderBy('encaissements.date_encaissement', 'desc');


    }


    public static function getTvaReport()
    {
        return operation::join('budgets', 'budgets.id', '=', 'operations.budget_id')
            ->join('exercice_comptables', 'exercice_comptables.id', '=', 'budgets.exercice_comptable_id')
            ->select(
                DB::raw('YEAR(date_operation) as year'),
                DB::raw('MONTH(date_operation) as month'),
                DB::raw('(SELECT COALESCE(SUM(montant_tva), 0) FROM operations WHERE montant_depense = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month) as tva_collecte'),
                DB::raw('(SELECT COALESCE(SUM(montant_tva), 0) FROM operations WHERE montant_recette = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month) as tva_deductible'),
                DB::raw('(SELECT COALESCE(SUM(montant_tva), 0) FROM operations WHERE montant_depense = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month) - (SELECT COALESCE(SUM(montant_tva), 0) FROM operations WHERE montant_recette = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month) as tva_due'),
                'budgets.exercice_comptable_id'
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');
    }

    public static function getAirsiReport()
    {
        return budget::leftJoin('budget_categories', 'budget_categories.id', '=', 'budgets.budget_categorie_id')
            ->leftJoin('operations', 'budgets.id', '=', 'operations.budget_id')
            ->leftJoin('client_details', 'operations.client_id', '=', 'client_details.id')
            ->leftJoin('users', 'users.id', '=', 'client_details.user_id')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->leftJoin('regime_impots', 'regime_impots.id', '=', 'client_details.regime_impot_id')
            ->join('exercice_comptables', 'exercice_comptables.id', '=', 'budgets.exercice_comptable_id')
            ->leftJoin('plan_comptables', 'plan_comptables.id', '=', 'budgets.plan_comptable_id')
            ->leftJoin('compte_majeurs', 'compte_majeurs.id', '=', 'plan_comptables.compte_majeur_id')
            ->where('roles.name', 'client')
            ->whereIn('regime_name', ['RTE','RME'])
            ->select(
                DB::raw('YEAR(date_operation) as year'),
                DB::raw('MONTH(date_operation) as month'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE montant_depense = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month AND numero_compte IN ("7061", "7062", "7063", "7064", "7065", "7069", "6058", "6056", "6342", "6343", "6344")) as Airsi_vente_par_mois'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE montant_recette = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month AND numero_compte_majeur IN ("601", "602", "604", "608", "614", "616")) as Airsi_achat_par_mois'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE YEAR(date_operation) = year AND MONTH(date_operation) = month AND (numero_compte IN ("7061", "7062", "7063", "7064", "7065", "7069", "6058", "6056", "6342", "6343", "6344") OR numero_compte_majeur IN ("601", "602", "604", "608", "614", "616"))) as total_Airsi'),
                'budgets.exercice_comptable_id'
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

    }
    public static function getPpsiReport()
    {
        return budget::leftJoin('budget_categories', 'budget_categories.id', '=', 'budgets.budget_categorie_id')
            ->leftJoin('operations', 'budgets.id', '=', 'operations.budget_id')
            ->leftJoin('client_details', 'operations.client_id', '=', 'client_details.id')
            ->leftJoin('users', 'users.id', '=', 'client_details.user_id')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->leftJoin('regime_impots', 'regime_impots.id', '=', 'client_details.regime_impot_id')
            ->join('exercice_comptables', 'exercice_comptables.id', '=', 'budgets.exercice_comptable_id')
            ->leftJoin('plan_comptables', 'plan_comptables.id', '=', 'budgets.plan_comptable_id')
            ->leftJoin('compte_majeurs', 'compte_majeurs.id', '=', 'plan_comptables.compte_majeur_id')
            ->where('roles.name', 'client')
            ->whereIn('regime_name', ['RTE','RME'])
            ->select(
                DB::raw('YEAR(date_operation) as year'),
                DB::raw('MONTH(date_operation) as month'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE montant_depense = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month AND numero_compte IN ("6343", "6343", "6344", "6345", "6346", "6057", "6381", "6382", "6383")) as Ppsi_vente_par_mois'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE montant_recette = 0 AND YEAR(date_operation) = year AND MONTH(date_operation) = month AND numero_compte_majeur IN ("621", "624", "627", "633")) as Ppsi_achat_par_mois'),
                DB::raw('(SELECT COALESCE(SUM(montant_operation_HT), 0) FROM operations WHERE YEAR(date_operation) = year AND MONTH(date_operation) = month AND (numero_compte IN ("6343", "6343", "6344", "6345", "6346", "6057", "6381", "6382", "6383") OR numero_compte_majeur IN ("621", "624", "627", "633"))) as total_Ppsi'),
                'budgets.exercice_comptable_id'
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

    }

    public static function getTseReport()
    {
        return budget::leftJoin('budget_categories', 'budget_categories.id', '=', 'budgets.budget_categorie_id')
            ->leftJoin('operations', 'budgets.id', '=', 'operations.budget_id')
            ->join('exercice_comptables', 'exercice_comptables.id', '=', 'budgets.exercice_comptable_id')

            ->select(
                DB::raw('YEAR(operations.date_operation) as year'),
                DB::raw('MONTH(operations.date_operation) as month'),
                DB::raw('coalesce(sum(montant_recette_HT), 0) as total'), 
                'budgets.exercice_comptable_id'
            )
            ->whereIn('type_exploitation', ['produit','produitsHAO'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

    }



}
