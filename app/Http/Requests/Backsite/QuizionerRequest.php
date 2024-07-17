<?php

namespace App\Http\Requests\Backsite;

use App\Rules\Backsite\ValidatorUniqueName;
use App\Rules\Backsite\ValidatorUniqueSeq;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizionerRequest extends FormRequest
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
            case \Route::currentRouteName() == getLang().'backsite.quizioner.store':
                $rules['label'] = 'required';
                $rules['type'] = 'required|in:text,textarea,number,linear_scale,combobox,checkbox,radio';
                
                $rules['option_label.*'] = Rule::requiredIf(function () {
                    return in_array($this->input('type'), ['combobox', 'checkbox', 'radio']);
                });
                $rules['option_value.*'] = Rule::requiredIf(function () {
                    return in_array($this->input('type'), ['combobox', 'checkbox', 'radio']);
                });

                $rules['label_start'] = 'required_if:type,linear_scale';
                $rules['label_end'] = 'required_if:type,linear_scale';
                $rules['name'] = 'required|unique:form_customs,name';
                $rules['placeholder'] = 'required';
                // $rules['caption'] = 'required';
                $rules['seq'] = 'required|numeric';
                // $rules['validator'] = 'required';
                $rules['status'] = 'required|in:0,1';
                break;

            case \Route::currentRouteName() == getLang().'backsite.quizioner.update':
                $rules['label'] = 'required';
                $rules['type'] = 'required|in:text,textarea,number,linear_scale,combobox,checkbox,radio';
                
                $rules['option_label.*'] = Rule::requiredIf(function () {
                    return in_array($this->input('type'), ['combobox', 'checkbox', 'radio']);
                });
                $rules['option_value.*'] = Rule::requiredIf(function () {
                    return in_array($this->input('type'), ['combobox', 'checkbox', 'radio']);
                });

                $rules['name'] = [
                    'required',
                    new ValidatorUniqueName($this->route('semester'), $this->input('name'), $this->route('id'))
                    // Rule::unique('form_customs')->ignore($this->input('name'), 'name'),
                ];
                $rules['placeholder'] = 'required';
                // $rules['caption'] = 'required';
                $rules['seq'] = [
                    'required',
                    'numeric',
                    // new ValidatorUniqueSeq($this->route('semester'), $this->input('seq'), $this->route('id'))
                    // Rule::unique('form_customs')->ignore($this->input('seq'), 'seq'),
                ];
                // $rules['validator'] = 'required';
                $rules['status'] = 'required|in:0,1';
                break;
        }

        return $rules;
    }
}
