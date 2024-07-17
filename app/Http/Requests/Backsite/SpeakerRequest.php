<?php

namespace App\Http\Requests\Backsite;

use Illuminate\Foundation\Http\FormRequest;

class SpeakerRequest extends FormRequest
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
            case \Route::currentRouteName() == getLang().'backsite.speaker.store':
                $rules['speaker_name'] = 'required';
                $rules['photo'] = 'required|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096';
                $rules['position'] = 'required';
                $rules['desc'] = 'sometimes';
                break;
            case \Route::currentRouteName() == getLang().'backsite.speaker.update':
                $rules['speaker_name'] = 'required';
                $rules['photo'] = 'sometimes|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096';
                $rules['position'] = 'required';
                $rules['desc'] = 'sometimes';
                // $rules['status'] = 'required|in:0,1';
                break;
        }

        return $rules;
    }
}
