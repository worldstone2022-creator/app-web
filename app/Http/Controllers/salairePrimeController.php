<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\salairePrime\StoreRequest;
use App\Http\Requests\salairePrime\UpdateRequest;
use App\Models\BaseModel;
use App\Models\salaire_primeIndemnite;
use App\Models\EmployeeDetails;
use Auth;
class salairePrimeController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.salairePrime';
        $this->middleware('auth');
        /*$this->middleware(function ($request, $next) {
            abort_403(!in_array('paie', $this->user->modules));
            return $next($request);
        });*/
    }

    public function create()
    {
        $this->salairePrime = salaire_primeIndemnite::allsalairePrime();
        return view('salairePrime.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        
        $group = new salaire_primeIndemnite();
        $group->libelle_prime = $request->libelle_prime;
        $group->type_prime = $request->type_prime;
        $group->nbreJTaux = $request->nbreJTaux;


        $group->save();

        $salairePrime = salaire_primeIndemnite::allsalairePrime();

        $options = BaseModel::options($salairePrime, $group);

        return Reply::successWithData(__('messages.salaire_categoriel'), ['data' => $options]);
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

        $group = salaire_primeIndemnite::find($id);
        $group->libelle_prime = strip_tags($request->libelle_prime);
        $group->type_prime = strip_tags($request->type_prime);
        $group->nbreJTaux = strip_tags($request->nbreJTaux);
        //return $group;
        $group->save();

        $salairePrime = salaire_primeIndemnite::allsalairePrime();
        $options = BaseModel::options($salairePrime);

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
        salaire_primeIndemnite::destroy($id);

        $salairePrime = salaire_primeIndemnite::allsalairePrime();
        $options = BaseModel::options($salairePrime);

        return Reply::successWithData(__('messages.deleteSuccess'), ['data' => $options]);
    }

}
