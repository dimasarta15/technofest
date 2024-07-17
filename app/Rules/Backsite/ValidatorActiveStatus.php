<?php

namespace App\Rules\Backsite;

use Illuminate\Contracts\Validation\Rule;

class ValidatorActiveStatus implements Rule
{
    private $model;
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $id)
    {
        //
        $this->model = $model;
        $this->id = $id;
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
        //
        if ($this->model->whereId($this->id)->first()->status == 1)
            return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, You cannot delete this data causing: status is active !';
    }
}
