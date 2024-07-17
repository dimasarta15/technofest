<?php

namespace App\Rules\Backsite;

use App\Models\FormCustom;
use Illuminate\Contracts\Validation\Rule;

class ValidatorUniqueName implements Rule
{
    private $name, $semester, $fcId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($semester, $name, $fcId)
    {
        $this->fcId = $fcId;
        $this->semester = $semester;
        $this->name = $name;
    }

    public function passes($attribute, $value)
    {
        $fc = FormCustom::where([
            'semester_id' => $this->semester,
            'name' => $this->name
        ])
        ->where('id', '!=', $this->fcId)
        ->count() <= 0;

        return $fc;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The input name already exists !';
    }
}
