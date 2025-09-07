<?php

namespace App\Http\Requests\salaireCategoriel;

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
            'categorie_sc' => 'required|unique:salaire_categoriels,categorie_sc,'.$this->route('salaireCategoriel'),
            'salaire_sc' => 'required'
        ];
    }

}
