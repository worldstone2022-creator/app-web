<?php

namespace App\Http\Requests\salairePrime;

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
            'libelle_prime' => 'required|unique:salaire_prime_indemnites,libelle_prime,'.$this->route('salairePrime'),
            'type_prime' => 'required'
        ];
    }

}
