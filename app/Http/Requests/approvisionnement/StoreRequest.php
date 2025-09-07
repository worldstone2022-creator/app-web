<?php

namespace App\Http\Requests\approvisionnement;

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
            'type_transaction' => 'required',
            'compte_tresorerie' => 'required',
            'montant_transaction' => 'required',
            'reference_transaction' => 'required|unique:approvisionnements',
            'date_transaction' => 'required'
        ];
    }

}
