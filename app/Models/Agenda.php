<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnArgument;

class Agenda extends Model
{
    use HasFactory;

    public function speaker()
    {
        return $this->hasOne(Speaker::class, 'id', 'speaker_id');
    }

    public function getEventDateAttribute($value) {
        if (!empty($value))
            return $this->attributes['even_date'] = Carbon::parse($value)->format('d-M-Y');
    }
}
