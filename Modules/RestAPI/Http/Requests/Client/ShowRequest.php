<?php

namespace Modules\RestAPI\Http\Requests\Client;

use Modules\RestAPI\Http\Requests\BaseRequest;

class ShowRequest extends BaseRequest
{
    /**
     * @return bool
     *
     * @throws \Froiden\RestAPI\Exceptions\UnauthorizedException
     */
    public function authorize()
    {
        $user = api_user();

        return in_array('clients', $user->modules) && ($user->hasRole('admin') || $user->cans('view_clients'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
