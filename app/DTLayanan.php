<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DTLayanan extends Model
{
    protected $table = 'dtlayanan';
    protected $primaryKey = ['noTransaksi', 'idLayanan'];
    public $incrementing = false;
    public $timestamps = false;

    public function layanan()
    {
        return $this->belongsTo('App\Layanan');
    }
}
