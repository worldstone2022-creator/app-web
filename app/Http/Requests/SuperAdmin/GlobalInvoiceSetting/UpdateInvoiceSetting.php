<?php

namespace App\Http\Requests\SuperAdmin\GlobalInvoiceSetting;

use App\Http\Requests\CoreRequest;

class UpdateInvoiceSetting extends CoreRequest
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
            'template' => 'required',
            'invoice_terms' => 'required'
        ];
    }

}
