<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_contract';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'receipt_number',
        'use_terms',
        'zip_cd',
        'prefectures_cd',
        'municipality_name',
        'townname_address',
        'building_name',
        'tel_no',
        'del_flg',
        'registered_person',
        'updater',
        'contractor_name',
    ];
}
