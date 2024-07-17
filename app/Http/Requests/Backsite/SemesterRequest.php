<?php

namespace App\Http\Requests\Backsite;

use App\Models\Semester;
use App\Rules\Backsite\ValidatorActiveStatus;
use App\Rules\Backsite\ValidatorPositionUnique;
use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('semester'),
        ]);
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
            case \Route::currentRouteName() == getLang().'backsite.semester.store':
                $rules['semester'] = 'required';
                $rules['title'] = 'required';
                $rules['visible'] = 'required|in:1,0';
                $rules['position'] = [
                    'required',
                    new ValidatorPositionUnique($this->input('position'))
                ];
                // $rules['status'] = 'required|in:0,1';
                break;
            case \Route::currentRouteName() == getLang().'backsite.semester.update':
                $rules['semester'] = 'required';
                $rules['title'] = 'required';
                $rules['visible'] = 'required|in:1,0';
                // $rules['position'] = [
                //     'required',
                //     new ValidatorPositionUnique($this->input('position'))
                // ];
                // $rules['status'] = 'required|in:0,1';
                break;
            case \Route::currentRouteName() == getLang().'backsite.semester.destroy':
                $rules['id'] = [
                    'required',
                    new ValidatorActiveStatus((new Semester), $this->input('id'))
                ];
                break;
        }

        return $rules;
    }
}
