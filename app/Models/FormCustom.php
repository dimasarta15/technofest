<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCustom extends Model
{
    use HasFactory;
    protected $appends = ['status_text'];

    public function semester()
    {
        return $this->hasOne(Semester::class, 'id', 'semester_id');
    }

    public function formOptions()
    {
        return $this->hasMany(FormOption::class, 'form_custom_id', 'id');
    }

    public function getStatusTextAttribute()
    {
        if (!empty($this->attributes['status']))
            return $this->attributes['status'] = $this->attributes['status'] == 1 ? "Active" : "Non-Active";
    }

    public function formResponse()
    {
        return $this->hasMany(FormResponse::class, 'form_custom_id', 'id');
    }
}
