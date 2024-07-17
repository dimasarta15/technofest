<?php

namespace App\Models\OldTechnofest;

use App\Models\Major;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbKarya extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table ='TB_KARYA';

    public function TbAuthor()
    {
        return $this->hasMany(TbAuthor::class, 'ID_KARYA', 'ID_KARYA');
    }

    public function TbFoto()
    {
        return $this->hasMany(TbFoto::class, 'ID_KARYA', 'ID_KARYA');
    }

    public function TbProdi()
    {
        return $this->hasOne(TbProdi::class, 'ID_PRODI', 'PRODI');
    }

    public function TbSemester()
    {
        return $this->hasOne(TbSemester::class, 'ID_SEMESTER', 'ID_SEMESTER');
    }
}
