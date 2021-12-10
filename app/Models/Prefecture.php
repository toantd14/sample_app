<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefecture extends Model
{
    use SoftDeletes;

    protected $table = 'mst_prefectures';
    protected $primaryKey = 'prefectures_cd';

    protected $fillable = [
        'prefecture_cd',
        'prefectures_name',
        'registered_person',
        'updater'
    ];

    public function scopeName($query, $name)
    {
        return $query->when($name, function ($query) use ($name) {
            return $query->where('prefectures_name', $name);
        });
    }

    public function owner()
    {
        return $this->hasMany(Owner::class, 'prefectures_cd', 'prefectures_cd');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'prefectures_cd', 'prefectures_cd');
    }
}
