<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOption extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeOptionValue($query, $value)
    {
        return $query->where('option_value', $value);
    }
}
