<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_holidays';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'date',
        'comment',
        'registered_person',
        'updater'
    ];
}
