<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingSpace extends Model
{
    use SoftDeletes;

    const KBN_STANDARD_ENABLE= 1;
    const KBN_STANDARD_DISABLE = 0;
    const KBN_3NO_ENABLE = 1;
    const KBN_3NO_DISABLE = 0;
    const KBN_LIGHTCAR_ENABLE= 1;
    const KBN_LIGHTCAR_DISABLE = 0;
    const CARTYPE_KBN_STANDARD = 1;
    const CARTYPE_KBN_3NO = 2;

    protected $table = 'tbl_parking_space';
    protected $primaryKey = 'serial_no';
    protected $fillable = [
        'serial_no',
        'parking_cd',
        'child_number',
        'parking_form',
        'space_symbol',
        'space_no',
        'kbn_standard',
        'kbn_3no',
        'kbn_lightcar',
        'car_width',
        'car_length',
        'car_height',
        'car_weight',
        'created_at',
        'updated_at',
        'registered_person',
        'updater',
    ];

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_cd', 'parking_cd');
    }

    public function scopeSlotParking($query, $parkingCd )
    {
        return $query->where('parking_cd', $parkingCd);
    }

    public function scopeSpaceSymbol($query, $spaceSymbol )
    {
        return $query->where('space_symbol', $spaceSymbol);
    }

    public function scopeSpaceNo($query, $spaceNo )
    {
        return $query->where('space_no', $spaceNo);
    }

    public function scopeNotSerialNo($query, $serialNo )
    {
        return $query->whereNotIn('serial_no', [$serialNo]);
    }
}
