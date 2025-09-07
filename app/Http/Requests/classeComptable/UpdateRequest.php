<?php

namespace App\Http\Requests\classeComptable;

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

            
            'libelle_classe' => 'required|unique:classe_plan_comptables,libelle_classe,'.$this->route('classeComptable'),
            'libelle_compte_comptable' => 'required|unique:classe_plan_comptables,libelle_compte_comptable,'.$this->route('classeComptable'),
        ];
    }

}
