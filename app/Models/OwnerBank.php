<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerBank extends Model
{
    const NORMAL_ACCOUNT = 0;
    const TRADE_ACCOUNT = 1;

    protected $table = 'tbl_owner_bank';
    protected $primaryKey = 'owner_cd';

    //account type
    const TYPE_NORMA = 0;
    const TYPE_PAYMENT = 1;

    const TYPE_BANK = [
        0 => '普通',
        1 => '当座'
    ];

    protected $fillable = [
        'owner_cd',
        'bank_cd',
        'bank_name',
        'branch_cd',
        'branch_name',
        'account_type',
        'account_name',
        'account_kana',
        'account_no',
        'registered_person',
        'updater',
        'updated_at'
    ];
}
