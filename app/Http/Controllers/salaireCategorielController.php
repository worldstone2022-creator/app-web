<?php

namespace App\Http\Controllers;

use App\Helper\Reply;
use App\Http\Requests\salaireCategoriel\StoreRequest;
use App\Http\Requests\salaireCategoriel\UpdateRequest;
use App\Models\BaseModel;
use App\Models\salaire_categoriel;
use App\Models\EmployeeDetails;
use Auth;
class salaireCategorielController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.salaireCategoriel';
        $this->middleware('auth');
        /*$this->middleware(function ($request, $next) {
            abort_403(!in_array('paie', $this->user->modules));
            return $next($request);
        });*/
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
        
        $group = new salaire_categoriel();
        $group->categorie_sc = $request->categorie_sc;
        $group->salaire_sc = $request->salaire_sc;
        $group->name = $request->categorie_sc .' --> '.$request->salaire_sc;


        $group->save();

        $salaireCategoriel = salaire_categoriel::allSalaireCategoriel();

        $options = BaseModel::options($salaireCategoriel, $group);

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

        $group = salaire_categoriel::find($id);
        $group->categorie_sc = strip_tags($request->categorie_sc);
        $group->salaire_sc = strip_tags($request->salaire_sc);
        $group->name = strip_tags($request->categorie_sc) .' --> '.strip_tags($request->salaire_sc);
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

}
