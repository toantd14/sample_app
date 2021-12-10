<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingMenu extends Model
{
    const MONTH_FLG_ENABLE = 0;
    const MONTH_FLG_DISABLE = 1;
    const PERIOD_FLG_ENABLE = 0;
    const PERIOD_FLG_DISABLE = 1;
    const TIME_FLG_ENABLE = 0;
    const TIME_FLG_DISABLE = 1;
    const PERIOD_TIME_FLG_ENABLE = 1;
    const PERIOD_TIME_FLG_DISABLE = 0;
    const PERIOD_DAY_FLG_ENABLE = 1;
    const PERIOD_DAY_FLG_DISABLE = 0;
    const PERIOD_WEEK_FLG_ENABLE = 1;
    const PERIOD_WEEK_FLG_DISABLE = 0;

    const DAY_FLG_ENABLE = 0;
    const DAY_FLG_DISABLE = 1;
    const PARKING_MENU_ON = 1;
    const PARKING_MENU_OFF = 0;

    const FLG_ENABLE = 0;
    const FLG_DISABLE = 1;

    protected $table = 'mst_parking_menu';
    protected $primaryKey = 'menu_cd';
    protected $fillable = [
        'parking_cd',
        'owner_cd',
        'month_flg',
        'month_price',
        'minimum_use',
        'period_flg',
        'period_week',
        'period_monday',
        'period_tuesday',
        'period_wednesday',
        'period_thursday',
        'period_friday',
        'period_saturday',
        'period_sunday',
        'period_holiday',
        'period_timeflg',
        'period_fromtime',
        'period_totime',
        'period_dayflg',
        'period_fromday',
        'period_today',
        'period_price',
        'day_flg',
        'day_price',
        'time_flg',
        'registered_person',
        'updater',
    ];

    public function parkingMenuTime()
    {
        return $this->hasMany(ParkingMenuTime::class, 'menu_cd', 'menu_cd')->orderBy('day_type', 'asc')->orderBy('from_time', 'asc');
    }

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_cd', 'parking_cd');
    }

    public function parkingSpace()
    {
        return $this->belongsTo(ParkingSpace::class, 'parking_cd', 'parking_cd');
    }

    public function scopeOwnerCd($query, $owner_cd)
    {
        return $query->where('owner_cd', $owner_cd);
    }

    public function scopeMenuMaster($query, $ownerCd)
    {
        return $query->where([
            'parking_cd' => null,
            'owner_cd' => $ownerCd
        ]);
    }
}
