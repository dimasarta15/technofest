<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSupervisor extends Model
{
    protected $fillable = ['supervisor'];
    use HasFactory;
}
