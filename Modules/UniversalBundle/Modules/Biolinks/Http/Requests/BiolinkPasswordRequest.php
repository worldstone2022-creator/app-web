<?php

namespace Modules\Biolinks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiolinkPasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

}
