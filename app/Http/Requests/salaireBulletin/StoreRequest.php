<?php

namespace App\Http\Requests\salaireBulletin;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends CoreRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'partIGR' => 'required',
            'categorie' => 'required',
            'ancienneteText' => 'required',
            'dateDebutSalaire' => 'required',
            'dateFinSalaire' => 'required',
            'salaireCategorie' => 'required',
            'conges_mensuel_acquis' => 'required',
            
        ];
    }

}
