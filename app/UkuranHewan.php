<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UkuranHewan extends Model
{
    protected $table = 'ukuranHewan';
    protected $primaryKey = 'idJenis'; 
    public $incrementing = false;
}
