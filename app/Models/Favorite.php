<?php

namespace App\Models;

use App\Models\MstUser;
use App\Models\ParkingLot;
use App\Models\UseSituation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_favorite';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'receipt_number',
        'parking_cd',
        'user_cd',
        'del_flg',
        'registered_person',
        'updater'
    ];

    const NOT_DELETED = 0;
    const DELETED = 1;

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
}
