<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisHewan extends Model
{
    use SoftDeletes;

    protected $table = 'jenishewan';
    protected $primaryKey = 'idJenis';
    public $incrementing = false;

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'idPegawaiLog');
    }
}
