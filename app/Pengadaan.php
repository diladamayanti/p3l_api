<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengadaan extends Model
{
    use SoftDeletes;
    protected $table = 'pengadaan';
}
