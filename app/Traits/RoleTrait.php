<?php
/**
* @author Nando (c) 2021
* Role traits ala-ala
*/
namespace App\Traits;
use App\Models\Role;

trait RoleTrait
{
    public function scopeIsSuperadmin()
    {
        return auth()->user()->role_id == Role::ROLES['superadmin'];
    }

    public function scopeIsModerator()
    {
        return auth()->user()->role_id == Role::ROLES['moderator'];
    }

    public function scopeIsParticipant()
    {
        return auth()->user()->role_id == Role::ROLES['participant'];
    }
}