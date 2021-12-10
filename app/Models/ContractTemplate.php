<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_contract_template';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'use_terms',
        'del_flg',
        'registered_person',
        'updater'
    ];
}
