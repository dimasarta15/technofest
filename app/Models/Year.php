<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    public $appends = ['status_text'];

    public function getStatusTextAttribute($value) {
        $x = $this->attributes['status'] = $this->attributes['status'] == 1 ? "Active" : "Non-Active";
        return $x;
    }

    public function getCreatedAtAttribute($value) {
        if (!empty($value))
            return $this->attributes['created_at'] = Carbon::parse($value)->format('d/M/Y H:i:s');
    }
}
