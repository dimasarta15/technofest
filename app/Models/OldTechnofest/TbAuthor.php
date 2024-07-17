<?php

namespace App\Models\OldTechnofest;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbAuthor extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table ='TB_AUTHOR';
}
