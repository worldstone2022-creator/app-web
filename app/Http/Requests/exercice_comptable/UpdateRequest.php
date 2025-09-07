<?php

namespace App\Http\Requests\exercice_comptable;

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

            'date_fin_exercice' => 'required',
            'date_debut_exercice' => 'required',
            'titre_exercice' => 'required|unique:exercice_comptables,titre_exercice,'.$this->route('excercice_comptable'),
        ];
    }

}
