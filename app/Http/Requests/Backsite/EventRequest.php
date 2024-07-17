<?php

namespace App\Http\Requests\Backsite;

use App\Rules\Backsite\ValidatorYoutubePhoto;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            case \Route::currentRouteName() == getLang().'backsite.event.store':
                $rules['title'] = [
                    'required',
                    new ValidatorYoutubePhoto()
                ];
                $rules['photo'] = 'sometimes|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096';
                $rules['lang'] = 'required|in:en,id';
                break;
            case \Route::currentRouteName() == getLang().'backsite.event.update':
                $rules['title'] = 'required';
                $rules['photo'] = 'sometimes|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096';
                $rules['lang'] = 'required|in:en,id';
                break;
        }

        return $rules;
    }
}
