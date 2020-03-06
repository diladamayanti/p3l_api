<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DTProduk extends Model
{
    protected $table = 'dtproduk';
    protected $primaryKey = ['noTransaksi', 'idProduk'];
    public $incrementing = false;
    public $timestamps = false;
}
