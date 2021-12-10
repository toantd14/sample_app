<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MstAdmin extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'mst_admin';
    protected $primaryKey = 'serial_no';
    protected $fillable = [
        'serial_no',
        'name_sei',
        'name_mei',
        'login_mail',
        'passw',
        'del_flg',
        'registered_person',
        'updater'
    ];

    public function setPasswAttribute($value)
    {
        $this->attributes['passw'] = Hash::make($value);
    }
}
