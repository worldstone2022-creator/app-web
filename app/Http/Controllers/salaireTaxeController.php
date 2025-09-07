<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\salaireTaxe\StoreRequest;
use App\Http\Requests\salaireTaxe\UpdateRequest;
use App\Models\BaseModel;
use App\Models\salaire_taxe;
use App\Models\EmployeeDetails;
use Auth;
class salaireTaxeController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.salaireTaxe';
        $this->middleware('auth');
        /*$this->middleware(function ($request, $next) {
            abort_403(!in_array('paie', $this->user->modules));
            return $next($request);
        });*/
    }

    public function create()
    {
        $this->salaireTaxe = salaire_taxe::allsalaireTaxe();
        return view('salaireTaxe.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        
        $group = new salaire_taxe();
        $group->libelle_taxe = $request->libelle_taxe;
        $group->type_obligation = $request->type_obligation;
        $group->taux_salarial = $request->taux_salarial;
        $group->taux_patronal = $request->taux_patronal;
        $group->methodeCalcul = $request->methodeCalcul;
        $group->baseCalcule = $request->baseCalcule;
        $group->TypeApplicable = $request->TypeApplicable;




        $group->save();

        $salaireTaxe = salaire_taxe::allsalaireTaxe();

        $options = BaseModel::options($salaireTaxe, $group);

        return Reply::successWithData(__('messages.salaire_taxe'), ['data' => $options]);
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

        $group = salaire_taxe::find($id);
        $group->libelle_taxe = strip_tags($request->libelle_taxe);
        $group->type_obligation = strip_tags($request->type_obligation);
        $group->taux_salarial = strip_tags($request->taux_salarial);
        $group->taux_patronal = strip_tags($request->taux_patronal);
        $group->methodeCalcul = strip_tags($request->methodeCalcul);
        $group->baseCalcule = strip_tags($request->baseCalcule);
        $group->TypeApplicable = strip_tags($request->TypeApplicable);
        //return $group;
        $group->save();

        $salaireTaxe = salaire_taxe::allsalaireTaxe();
        $options = BaseModel::options($salaireTaxe);

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
        salaire_taxe::destroy($id);

        $salaireTaxe = salaire_taxe::allsalaireTaxe();
        $options = BaseModel::options($salaireTaxe);

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }

}
