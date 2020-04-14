<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanan';
    protected $primaryKey = 'idLayanan';
    public $incrementing = false;

    public function ukuran()
    {
        return $this->hasOne(UkuranHewan::class, 'idUkuran');
    }
}
