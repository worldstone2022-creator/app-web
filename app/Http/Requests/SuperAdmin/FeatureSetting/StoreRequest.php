<?php

namespace App\Http\Requests\SuperAdmin\FeatureSetting;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $rules = [
            'title' => 'required',

        ];

        if(request('type') == 'icon')
        {
            $rules['icon'] = 'required';
        }
        elseif(request('type') == 'image' || request('type') == 'apps') {
            $rules['image'] = 'required';
        }

        if(request('type') !== 'apps'){
            $rules['description'] = 'required';
        }


        return $rules;
    }

}
