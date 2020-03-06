<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $primaryKey = 'noPO'; 
    public $incrementing = false;
}
