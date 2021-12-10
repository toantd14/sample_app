<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UseTerm extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_use_terms';
    protected $primaryKey = 'serial_no';

    protected $fillable = [
        'serial_no',
        'use_terms',
        'registered_person',
        'updater'
    ];

}
