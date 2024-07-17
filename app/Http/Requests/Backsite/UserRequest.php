<?php

namespace App\Http\Requests\Backsite;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [];
        $uri = $this->route()->uri;
        switch (true) {
            case \Route::currentRouteName() == getLang().'backsite.user.store':
                $rules['role_ref'] = 'required|exists:roles,ref';
                $rules['name'] = 'required';
                $rules['email'] = 'required|email';
                $rules['password'] = 'required';
                if ($this->input('role_ref') == Role::ROLES['participant']) {
                    $rules['nrp'] = 'required|numeric';
                    $rules['college_origin'] = 'required';
                }
                $rules['telephone'] = 'required';
                break;
            case \Route::currentRouteName() == getLang().'backsite.user.update':
                $rules['role_ref'] = 'required|exists:roles,ref';
                $rules['name'] = 'required';
                $rules['email'] = 'required|email';
                if ($this->input('role_ref') == Role::ROLES['participant']) {
                    $rules['nrp'] = 'required|numeric';
                    $rules['college_origin'] = 'required';
                }
                $rules['telephone'] = 'required';
                break;
            case \Route::currentRouteName() == getLang().'backsite.user.update-profile':
                $rules['name'] = 'required';
                $rules['email'] = 'required|email';
                if ($this->input('role_ref') == Role::ROLES['participant']) {
                    $rules['nrp'] = 'required|numeric';
                    $rules['college_origin'] = 'required';
                }
                $rules['telephone'] = 'required';
                break;
        }

        return $rules;
    }
}
