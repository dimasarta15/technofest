<?php

namespace App\Rules\Backsite;

use Illuminate\Contracts\Validation\Rule;

class ValidatorYoutubePhoto implements Rule
{
    /* private $photo;
    private $yt; */

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->photo = $photo;
        // $this->yt = $yt;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty(request()->youtube) && empty(request()->photo)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Youtube and/or Photo field must be filled !';
    }
}
