<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value) {
        if (!empty($value))
            return $this->attributes['created_at'] = Carbon::parse($value)->format('d/M/Y H:i:s');
    }

    public function scopeName($q, $v)
    {
        return $q->where('name', $v);
    }
}
