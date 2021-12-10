<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'tbl_question';

    public  $fillable = [
        'serial_no',
        'category_id',
        'title_name',
        'contents',
        'del_flg',
        'registered_person',
        'updater'
    ];

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id', 'category_id');
    }
}
