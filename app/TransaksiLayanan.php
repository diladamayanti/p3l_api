<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiLayanan extends Model
{
    protected $table = 'transaksiLayanan';
    protected $primaryKey = 'noTransaksi'; 
    public $incrementing = false;
}
