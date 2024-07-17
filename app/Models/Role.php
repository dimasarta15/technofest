<?php

namespace App\Models;

use App\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, RoleTrait;

    const ROLES = [
        'superadmin' => 1,
        'moderator' => 2,
        'participant' => 3
    ];

    public function scopeRef($query, $value)
    {
        return $query->where('ref', $value);
    }
}
