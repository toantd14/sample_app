<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class OwnerPass extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'tbl_owner_pass';
    protected $primaryKey = 'member_cd';
    public $incrementing = false;

    protected $fillable = [
        'member_cd',
        'pass',
        'registered_person',
        'updater',
    ];

    public function scopePass($query, $pass) {
        return $query->where('pass', $pass);
    }

    public function setPassAttribute($value)
    {
        $this->attributes['pass'] = Hash::make($value);
    }

}
