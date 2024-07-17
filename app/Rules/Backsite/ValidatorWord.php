<?php

namespace App\Rules\Backsite;

use Illuminate\Contracts\Validation\Rule;

class ValidatorWord implements Rule
{
    private $text;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
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
        if (str_word_count($this->text) > 200) {
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
        return 'Your words more than 200 !';
    }
}
