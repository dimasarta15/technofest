<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $appends = ['raw_desc'];
    use HasFactory;

    public function getRawDescAttribute($value)
    { 
      return strip_tags($this->attributes['desc']);
    }
}
