<?php

namespace App\Http\Requests\chargeType;

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
            'numero_compte' => 'required|unique:charge_types,numero_compte,'.$this->route('chargeType'),
            'libelle_charge' => 'required|unique:charge_types,libelle_charge,'.$this->route('chargeType'),
        ];
    }

}
