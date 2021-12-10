<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $table = 'mst_question_category';

    protected $primaryKey = 'category_id';

    public  $fillable = [
        'category_id',
        'category_name',
        'del_flg',
        'registered_person',
        'updater'
    ];

    const MAX_RESOURCE_RESULT = 6;

    function questions()
    {
        return $this->hasMany(Question::class, 'category_id', 'category_id');
    }
}
