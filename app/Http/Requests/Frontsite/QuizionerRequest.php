<?php

namespace App\Http\Requests\Frontsite;

use App\Models\FormCustom;
use App\Models\Semester;
use Illuminate\Foundation\Http\FormRequest;

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
        switch (true) {
            case \Route::currentRouteName() == 'frontsite.quizioner.store':
                $rules['g-recaptcha-response'] = 'required|recaptchav3:quizioner,0.5';

                $activeSemester = Semester::active()->first();
                $fc = FormCustom::where('semester_id', $activeSemester->id)->orderBy('seq', 'asc')->get();
                
                foreach ($fc as $key => $f) {
                    if (!empty(json_decode($f->validator, true)))
                        $rules[$f->name] = implode("|", json_decode($f->validator, true));
                }
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.recaptchav3' => 'Google recaptcha tidak valid !',
        ];
    }
}
