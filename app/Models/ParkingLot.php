<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingLot extends Model
{
    use SoftDeletes;

    // TODO update constant of all project
    const SALES_DIVISION_DISABLE = 0;
    const SALES_DIVISION_ENABLE = 1;
    const LU_DIVISION_DISABLE = 0;
    const LU_DIVISION_ENABLE = 1;
    const VIDEO_IMAGE_NUMBER = 4;

    const LOANTYPE_TRUE = 0;
    const LOANTYPE_FALSE = 1;

    const KBN_TRUE = 1;
    const KBN_FALSE = 0;

    const SORT_BY_DISTANCE = 1;
    const SORT_BY_EVALUATION = 2;
    const SORT_BY_COUNT_REVIEW = 3;

    const REENTER_DISABLE = 0;
    const REENTER_ENABLE = 1;
    const LOCAL_PAYOFF_DISABLE = 0;
    const LOCAL_PAYOFF_ENABLE = 1;
    const NET_PAYOFF_DISABLE = 0;
    const NET_PAYOFF_ENABLE = 1;

    const MGN_FLG_ENABLE = 0;
    const MGN_FLG_DISABLE = 1;

    protected $table = 'tbl_parking_lot';
    protected $primaryKey = 'parking_cd';

    protected $fillable = [
        'parking_cd',
        'owner_cd',
        'mgn_flg',
        'parking_name',
        'zip_cd',
        'prefectures_cd',
        'municipality_name',
        'townname_address',
        'building_name',
        'latitude',
        'longitude',
        'tel_no',
        'fax_no',
        'sales_division',
        'sales_start_time',
        'sales_end_time',
        'lu_division',
        'lu_start_time',
        'lu_end_time',
        'warn',
        'image1_url',
        'image2_url',
        'image3_url',
        'image4_url',
        'video1_url',
        'video2_url',
        'video3_url',
        'video4_url',
        'thumbnail_video',
        'registered_person',
        'updater',
        're_enter',
        'net_payoff',
        'local_payoff',
    ];

    public function parkingSpaces()
    {
        return $this->hasMany(ParkingSpace::class, 'parking_cd', 'parking_cd');
    }

    public function parkingMenu()
    {
        return $this->hasOne(ParkingMenu::class, 'parking_cd', 'parking_cd');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'parking_cd', 'parking_cd');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'parking_cd', 'parking_cd');
    }

    public function useSituations()
    {
        return $this->hasMany(UseSituation::class, 'parking_cd', 'parking_cd');
    }

    public function prefecture()
    {
        return $this->hasOne(Prefecture::class, 'prefectures_cd', 'prefectures_cd');
    }

    public function ownerNotices()
    {
        return $this->hasMany(OwnerNotice::class, 'parking_cd', 'parking_cd');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class, 'owner_cd', 'owner_cd');
    }

    public function scopeOwnerCd($query, $ownerCd)
    {
        $query->when($ownerCd, function ($query) use ($ownerCd) {
            return $query->where('owner_cd', $ownerCd);
        });
    }

    public function scopeCode($query, $code)
    {
        return $query->where('zip_cd', $code);
    }

    public function getEvaluation()
    {
        return collect(
            [
                $this->reviews()->avg('evaluation_satisfaction'),
                $this->reviews()->avg('evaluation_location'),
                $this->reviews()->avg('evaluation_ease_stopping'),
                $this->reviews()->avg('evaluation_fee')
            ]
        )->avg();
    }

    public function scopeLoanType($query, $loanType)
    {
        $timeFlg = in_array('time_flg', $loanType) ? ParkingLot::LOANTYPE_TRUE : ParkingLot::LOANTYPE_FALSE;
        $dayFlg = in_array('day_flg', $loanType) ? ParkingLot::LOANTYPE_TRUE : ParkingLot::LOANTYPE_FALSE;
        $monthFlg = in_array('month_flg', $loanType) ? ParkingLot::LOANTYPE_TRUE : ParkingLot::LOANTYPE_FALSE;
        $periodFlg = in_array('period_flg', $loanType) ? ParkingLot::LOANTYPE_TRUE : ParkingLot::LOANTYPE_FALSE;

        return $query->whereHas('parkingMenu', function ($query) use ($timeFlg, $dayFlg, $monthFlg, $periodFlg) {
            $timeFlg == ParkingLot::LOANTYPE_TRUE ? $query->where('time_flg', $timeFlg) : $query;
            $dayFlg == ParkingLot::LOANTYPE_TRUE ? $query->where('day_flg', $dayFlg) : $query;
            $monthFlg == ParkingLot::LOANTYPE_TRUE ? $query->where('month_flg', $monthFlg) : $query;
            $periodFlg == ParkingLot::LOANTYPE_TRUE ? $query->where('period_flg', $periodFlg) : $query;
        });
    }

    public function scopeUseDate($query, $useDate)
    {
        $useTime = Carbon::parse(str_replace(" ", "+", $useDate))
            ->timezone(config('app.timezone'))
            ->format(config('constants.API.HOUR_MIN'));

        return $query->where('sales_start_time', '<=', $useTime)
            ->where('sales_end_time', '>=', $useTime)
            ->orwhere('sales_division', ParkingLot::SALES_DIVISION_ENABLE);
    }

    public function scopePrefecturesCd($query, $prefecturesCd)
    {
        $query->when($prefecturesCd, function ($query) use ($prefecturesCd) {
            return $query->where('prefectures_cd', $prefecturesCd);
        });
    }

    public function scopeMunicipalityName($query, $municipalityName)
    {
        $query->when($municipalityName, function ($query) use ($municipalityName) {
            return $query->where('municipality_name', $municipalityName);
        });
    }

    public function scopeParkingCd($query, $parkingCd)
    {
        $query->when($parkingCd, function ($query) use ($parkingCd) {
            return $query->where('parking_cd', $parkingCd);
        });
    }

    public function scopeCreatedAt($query, $createdAtFrom, $createdAtTo)
    {
        $query->when($createdAtFrom, function ($query) use ($createdAtFrom) {
            return $query->whereDate('created_at', '>=', $createdAtFrom);
        });

        $query->when($createdAtTo, function ($query) use ($createdAtTo) {
            return $query->whereDate('created_at', '<=', $createdAtTo);
        });
    }

    public function scopeUpdatedAt($query, $updatedAtFrom, $updatedAtTo)
    {
        $query->when($updatedAtFrom, function ($query) use ($updatedAtFrom) {
            return $query->whereDate('updated_at', '>=', $updatedAtFrom);
        });

        $query->when($updatedAtTo, function ($query) use ($updatedAtTo) {
            return $query->whereDate('updated_at', '<=', $updatedAtTo);
        });
    }

    public function countParkingSpaces()
    {
        return $this->mgn_flg == self::MGN_FLG_DISABLE ? 0 : $this->parkingSpaces->count();
    }
}
