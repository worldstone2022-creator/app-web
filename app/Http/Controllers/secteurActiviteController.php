<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Requests\secteur_activite\StoreRequest;
use App\Http\Requests\secteur_activite\UpdateRequest;
use App\Models\secteur_activite;

class secteurActiviteController extends AccountBaseController
{

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->secteur = secteur_activite::all();
        return view('secteur_activite.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Storesecteur_activite $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $secteur = new secteur_activite();
        $secteur->name = strip_tags($request->name);
        $secteur->description_secteur_activite = strip_tags($request->description);

        $secteur->save();
        $secteur = secteur_activite::all();
        return Reply::successWithData("Secteur d'activité ajouté avec succès", ['data' => $secteur]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return array|void
     */
    public function update(Request $request, $id)
    {
        $this->editPermission = user()->permission('manage_client_category');
        abort_403 ($this->editPermission != 'all');

        $secteur = secteur_activite::find($id);
        $secteur->name = strip_tags($request->name);
        $secteur->description_secteur_activite = strip_tags($request->description);
        
        $secteur->save();

        $secteurData = secteur_activite::all();

        return Reply::successWithData(__('messages.updatedSuccessfully'), ['data' => $secteurData]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {

        $secteur = secteur_activite::findOrFail($id);
        $secteur->delete();
        $secteurData = secteur_activite::all();
        return Reply::successWithData("Supprimé avec succès", ['data' => $secteurData]);
    }

}
