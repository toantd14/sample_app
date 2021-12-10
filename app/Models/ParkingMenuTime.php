<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingMenuTime extends Model
{
    const WEEKDAYS = 0;
    const SATURDAY = 1;
    const SUNDAY = 2;
    const HOLIDAYS = 3;

    protected $table = 'mst_parking_menu_time';
    protected $primaryKey = 'id';

    protected $fillable = [
        'menu_cd',
        'day_type',
        'from_time',
        'to_time',
        'price',
        'registered_person',
        'updater',
    ];

    public function parkingMenu()
    {
        return $this->belongsTo(ParkingMenu::class, 'menu_cd', 'menu_cd');
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public static function getWith($column, $value)
    {
        return static::where($column, $value)->paginate(config('constants.PAGE_LIMIT'));
    }

    public function scopeMenuCd($query, $menuCd)
    {
        return $query->where('menu_cd', $menuCd);
    }

    public function scopeDayType($query, $dayType)
    {
        return $query->where('day_type', $dayType);
    }
}
