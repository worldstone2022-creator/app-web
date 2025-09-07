<?php

namespace App\Http\Requests\salaireTaxe;

use App\Http\Requests\CoreRequest;

class UpdateRequest extends CoreRequest
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
            'libelle_taxe' => 'required|unique:salaire_taxes,libelle_taxe,'.$this->route('salaireTaxe'),
            'type_obligation' => 'required'
        ];
    }

}
