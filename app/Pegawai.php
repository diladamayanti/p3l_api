<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    protected $table = 'pegawai';
    protected $primaryKey = 'NIP';
    public $incrementing = false;

    public function customer()
    {
        return $this->hasMany('App\Customer');
    }
}
