<?php

namespace App\Rules\Backsite;

use App\Models\FormCustom;
use App\Models\FormOption;
use Illuminate\Contracts\Validation\Rule;

class ValidatorUniqueSeq implements Rule
{
    private $seq, $semester, $fcId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($semester, $seq, $fcId)
    {
        $this->fcId = $fcId;
        $this->semester = $semester;
        $this->seq = $seq;
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
        $fc = FormCustom::where([
            'semester_id' => $this->semester,
            'seq' => $this->seq
        ])
        ->where('id', '!=', $this->fcId)
        ->count();
        // dd($fc);

        return $fc;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The sequence already exists !';
    }
}
