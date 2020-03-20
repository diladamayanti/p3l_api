<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengadaan extends Model
{
    use SoftDeletes;
    protected $table = 'pengadaan';

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'idSupplier');
    }
}
