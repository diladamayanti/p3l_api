<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hewan extends Model
{
    use SoftDeletes;

    protected $table = 'hewan';
    protected $primaryKey = 'idHewan';
    public $incrementing = false;

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function jenisHewan()
    {
        return $this->hasOne('App\JenisHewan');
    }
}
