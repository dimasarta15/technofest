<?php

namespace App\Http\Requests\Backsite;

use App\Rules\Backsite\ValidatorWord;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'major' => auth()->user()->major->name ?? auth()->user()->custom_major,
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
            case \Route::currentRouteName() == getLang().'backsite.project.store-image':
                $rules['file'] = 'required|file|max:5000|mimes:' . str_replace('.', '', config('media.allowed', ''));
                break;

            case \Route::currentRouteName() == getLang().'backsite.project.store':
                $rules['title'] = 'required';
                $rules['category'] = 'required|exists:categories,id';
                $rules['major'] = 'required';
                $rules['desc'] = [
                    'required',
                    new ValidatorWord($this->input('desc'))
                ];
                $rules['lecture'] = 'required';
                $rules['members.*'] = 'required';
                $rules['lang'] = 'required|in:en,id';
                break;
            case \Route::currentRouteName() == getLang().'backsite.project.update':
                $rules['title'] = 'required';
                $rules['category'] = 'required|exists:categories,id';
                // $rules['major'] = 'required|exists:majors,id';
                $rules['desc'] = [
                    'required',
                    new ValidatorWord($this->input('desc'))
                ];
                $rules['lecture'] = 'required';
                $rules['members.*'] = 'required';
                $rules['lang'] = 'required|in:en,id';
                break;
        }

        return $rules;
    }
}
