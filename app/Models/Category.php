<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $appends = ['new_created_at'];
    
    // public function getCreatedAtAttribute($value) {
    //     if (!empty($value))
    //         return $this->attributes['created_at'] = Carbon::parse($value)->format('d/M/Y H:i:s');
    // }

    public function getNewCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/M/Y H:i:s');
    }
}
