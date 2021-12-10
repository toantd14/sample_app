<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerNotice extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_owner_notice';
    protected $primaryKey = 'notics_cd';

    protected $fillable = [
        'member_cd',
        'notics_title',
        'notics_details',
        'site_url',
        'announce_period',
        'registered_person',
        'updater',
        'created_at',
        'updated_at',
        'parking_cd',
    ];

    public function scopeMemberCd($query, $memberCd)
    {
        return $query->where('member_cd', $memberCd);
    }

    public function scopeSearchByDate($query, $dateFrom, $dateTo)
    {
        $query->when($dateFrom, function ($query) use ($dateFrom) {
            return $query->whereDate('created_at', '>=', $dateFrom);
        });

        $query->when($dateTo, function ($query) use ($dateTo) {
            return $query->whereDate('created_at', '<=', $dateTo);
        });

        return $query;
    }

    public function scopeNoticeTitle($query, $title)
    {
        $query->when($title, function ($query) use ($title) {
            return $query->where('notics_title', 'like', '%' . $title . '%');
        });
    }

    public function scopeParkingCd($query, $parkingCd)
    {
        $query->when($parkingCd, function ($query) use ($parkingCd) {
            return $query->where('parking_cd', $parkingCd);
        });

        return $query;
    }

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_cd', 'parking_cd');
    }
}
