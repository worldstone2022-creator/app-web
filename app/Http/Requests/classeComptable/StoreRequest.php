<?php

namespace App\Http\Requests\classeComptable;

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
            'libelle_classe' => 'required|unique:classe_plan_comptables',
            'libelle_compte_comptable' => 'required|unique:classe_plan_comptables',
        ];
    }

}
