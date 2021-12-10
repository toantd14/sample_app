<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminNotice extends Model
{
    protected $primaryKey = "notics_cd";
    protected $table = "tbl_admin_notice";

    protected $fillable = [
        'notics_cd',
        'notics_title',
        'notics_details',
        'site_url',
        'registered_person',
        'updater'
    ];
}
