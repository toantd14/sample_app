<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_review';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'receipt_number',
        'parking_cd',
        'user_cd',
        'comment',
        'registered_person',
        'updater',
        'evaluation_satisfaction',
        'evaluation_location',
        'evaluation_ease_stopping',
        'evaluation_fee'
    ];

    public function useSituation()
    {
        return $this->belongsTo(UseSituation::class, 'receipt_number', 'receipt_number');
    }

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_cd', 'parking_cd');
    }

    public function mstUser()
    {
        return $this->belongsTo(MstUser::class, 'user_cd', 'user_cd');
    }

    public function scopeUserCd($query, $userCd)
    {
        return $query->where('user_cd', $userCd);
    }

    public function scopeParkingCd($query, $parkingCd)
    {
        return $query->where('parking_cd', $parkingCd);
    }
}
