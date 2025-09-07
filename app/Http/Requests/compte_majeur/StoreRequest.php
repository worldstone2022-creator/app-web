<?php

namespace App\Http\Requests\compte_majeur;

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
            'compte_general_id' => 'required',
            'numero_compte_majeur' => 'required|unique:compte_majeurs',
            'libelle_compte_majeur' => 'required',
        ];
    }

}
