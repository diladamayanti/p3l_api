<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';
    protected $primaryKey = 'idProduk';
    public $incrementing = false;

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'idPegawaiLog');
    }
}
