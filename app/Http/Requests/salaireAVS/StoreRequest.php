<?php

namespace App\Http\Requests\salaireAVS;

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
            'montantEmprunt' => 'required',
            'motif' => 'required',
            'dateEmprunt' => 'required',
        ];
    }

}
