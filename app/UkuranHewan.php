<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UkuranHewan extends Model
{
    use SoftDeletes;

    protected $table = 'ukuranHewan';
    protected $primaryKey = 'idUkuran';
    public $incrementing = false;

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'idPegawaiLog');
    }
}
