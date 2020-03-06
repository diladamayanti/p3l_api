<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiProduk extends Model
{
    protected $table = 'transaksiProduk';
    protected $primaryKey = 'noTransaksi'; 
    public $incrementing = false;
}
