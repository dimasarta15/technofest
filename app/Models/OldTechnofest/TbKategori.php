<?php

namespace App\Models\OldTechnofest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbKategori extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table ='TB_KATEGORI';
}