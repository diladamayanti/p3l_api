<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'idCustomer';

    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai');
    }
}
