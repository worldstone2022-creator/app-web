<?php

namespace App\Http\Requests\compte_general;

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
            'classe_id' => 'required',
            'numero_compte_general' => 'required|unique:compte_generals,numero_compte_general,'.$this->route('compte_general'),
            'libelle_compte_general' => 'required'
        ];
    }

}