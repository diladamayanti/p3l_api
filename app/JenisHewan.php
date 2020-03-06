<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    protected $table = 'jenishewan';
    protected $primaryKey = 'idJenis'; 
    public $incrementing = false;
}
