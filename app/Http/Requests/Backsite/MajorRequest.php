<?php

namespace App\Http\Requests\Backsite;

use Illuminate\Foundation\Http\FormRequest;

class MajorRequest extends FormRequest
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
            case \Route::currentRouteName() == getLang().'backsite.major.store':
            case \Route::currentRouteName() == getLang().'backsite.major.update':
                $rules['major'] = 'required';
                $rules['desc'] = 'sometimes';
                break;
        }

        return $rules;
    }
}
