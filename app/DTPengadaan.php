<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DTPengadaan extends Model
{
    protected $table = 'dtpengadaan';
    protected $primaryKey = ['noPO', 'idProduk'];
    public $incrementing = false;
    public $timestamps = false;

    public function pengadaan()
    {
        return $this->belongsTo('App\Pengadaan');
    }
}
