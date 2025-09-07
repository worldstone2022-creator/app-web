<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helper\Reply;
use App\Http\Requests\salaireBulletin\StoreRequest;
use App\Http\Requests\salaireBulletin\UpdateRequest;
use App\Models\BaseModel;
use App\Models\Role;
use App\Models\Designation;
use App\Models\salaire_categoriel;
use App\Models\salaire_primeIndemnite;
use App\Models\salaire_taxe;
use App\Models\salaire_bulletin;
use App\Models\salaire_bulletin_prime;
use App\Models\salaire_bulletin_taxe;
use App\Models\salaire_avance;

use App\Models\EmployeeDetails;
use App\Models\User;
use App\Models\TaskboardColumn;
use App\Models\Task;
use App\Models\ProjectTimeLog;
use App\Models\ProjectTimeLogBreak;
use App\Models\UserActivity;
use App\DataTables\PaieEmployeesDataTable;
use Auth;
class paieLivreController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.paie-livre';
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
    public function index(Request $request)
    {
        // $viewPermission = user()->permission('view_paiement_book');
        // abort_403(!in_array($viewPermission, ['all', 'added', 'owned', 'both']));
        $parts = explode(' ', $request->daterange);
        $mois = $parts[0];
        $moisFR = array(
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        );

        $moisEN = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );

        $cle = array_search($mois, $moisFR);

        if ($cle !== false) {
            $date=$cle.'-'.$parts[1];
            $date = Carbon::createFromFormat('m-Y', $date);
            $date_mois = $date->startOfMonth();
        } else {
            $cle = array_search($mois, $moisEN);
            if ($cle !== false){ 
                $date=$cle.'-'.$parts[1];
                $date = Carbon::createFromFormat('m-Y', $date);
                $date_mois = $date->startOfMonth();
            }else{
                $date_mois = Carbon::now()->subMonth()->startOfMonth();
            }
        }
        $mois = $date_mois->month;
        //dd($date_mois->month);
        $this->month = strftime('%B', mktime(0, 0, 0, $mois));
        $this->year = $date_mois->year;

        $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $this->prime = salaire_primeIndemnite::allsalairePrime();
        $this->taxe = salaire_taxe::allsalaireTaxe();
        

        $this->bulletin= $bulletin= DB::table('salaire_bulletins')
            ->join('employee_details', 'employee_details.user_id', '=', 'salaire_bulletins.user_id')
            ->join('users', 'employee_details.user_id', '=', 'users.id')
            ->join('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('teams', 'employee_details.department_id', '=', 'teams.id')
            ->join('salaire_categoriels', 'salaire_bulletins.categorie_id', '=', 'salaire_categoriels.id')
            ->select('salaire_bulletins.*', 'users.name', 'users.lastname', 'users.email', 'users.mobile', 'employee_details.address', 'num_cnps', 'designations.name as designation_name', 'team_name', 'categorie_sc', 'employee_id', 'users.salutation')
            ->distinct('salaire_fin')
            ->whereYear('salaire_fin', $date_mois->year)
            ->whereMonth('salaire_fin', $date_mois->month)
            ->get();

        $this->salairePrime =$salairePrime= DB::table('salaire_bulletin_primes')
            ->join('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_primes.bulletin_id')
            ->join('salaire_prime_indemnites', 'salaire_prime_indemnites.id', '=', 'salaire_bulletin_primes.prime_id')
            ->select('salaire_bulletin_primes.*', 'libelle_prime', 'type_prime')
            ->get();

        $this->salaireTaxe=$salaireTaxe = DB::table('salaire_bulletin_taxes')
            ->join('salaire_bulletins', 'salaire_bulletins.id', '=', 'salaire_bulletin_taxes.bulletin_id')
            ->join('salaire_taxes', 'salaire_taxes.id', '=', 'salaire_bulletin_taxes.taxe_id')
            ->select('salaire_bulletin_taxes.*', 'libelle_taxe')
            ->get();

        
        $dataAll = [];
        foreach ($bulletin as $row) {
            $data=[
                "bulletin"=>$row,
                "prime"=>$salairePrime->where('bulletin_id', $row->id),
                "taxe"=>$salaireTaxe->where('bulletin_id', $row->id)  
            ];
            array_push($dataAll, $data);
        }
        


        $this->paieLivre=$dataAll;
        //dd($this->salaireTaxe);
        //dd($totalITS);
        return view('paie.ajax.livre_paie', $this->data);
    }


    public function create()
    {
        $this->salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        return view('salaireCategoriel.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        
        $bulletin = new salaire_bulletin();
        $bulletin->user_id = $request->user_id;
        $bulletin->salaire_debut =Carbon::createFromFormat($this->global->date_format, $request->dateDebutSalaire)->format('Y-m-d');
        $bulletin->salaire_fin = Carbon::createFromFormat($this->global->date_format, $request->dateFinSalaire)->format('Y-m-d');
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

        return Reply::successWithData('Bulletin de Salaire édité avec succès', ['data' => $bulletin->id]);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return array
     * @throws \Froiden\RestAPI\Exceptions\RelatedResourceNotFoundException
     */
    public function update(UpdateRequest $request, $id)
    {
        //$editDesignation = user()->permission('edit_designation');
        //abort_403($editDesignation != 'all');

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
        //EmployeeDetails::where('designation_id', $id)->update(['designation_id' => null]);
        salaire_categoriel::destroy($id);

        $salaireCategoriel = salaire_categoriel::allSalaireCategoriel();
        $options = BaseModel::options($salaireCategoriel);

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }

    public function show($id)
    {
        

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

    
    public function masse_salariale(Request $request)
    {
      
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
