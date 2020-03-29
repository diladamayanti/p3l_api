<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Pegawai extends Authenticable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'pegawai';
    protected $primaryKey = 'NIP';
    public $incrementing = false;

    //public function customer()
    // {
    //     return $this->hasMany('App\Customer');
    // }

    protected $fillable = [
        'NIP',
        'nama',
        'alamat',
        'tglLahir',
        'noHP',
        'jabatan',
        'foto',
    ];

    protected $hidden = ['kataSandi'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
