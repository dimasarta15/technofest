<?php

namespace App\Models\OldTechnofest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbFoto extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table ='TB_FOTO';
}
