<?php

namespace App\Rules\Backsite;

use App\Models\Semester;
use Illuminate\Contracts\Validation\Rule;

class ValidatorPositionUnique implements Rule
{
    private $position;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($position)
    {
        $this->position = $position;
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
        if (\Route::currentRouteName() == 'backsite.semester.update') {
            return true;
        }

        return Semester::where('position', $this->position)->count() < 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Position already exists !';
    }
}
