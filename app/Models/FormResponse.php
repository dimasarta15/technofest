<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;

    public function formCustom()
    {
        return $this->hasOne(FormCustom::class, 'id', 'form_custom_id');
    }

    public function formOptions()
    {
        return $this->hasOne(FormOption::class, 'form_custom_id', 'form_custom_id');
    }

    public function getCreatedAtAttribute($value) {
        if (!empty($value))
            return $this->attributes['created_at'] = Carbon::parse($value)->format('d-M-Y H:i:s');
    }
}
