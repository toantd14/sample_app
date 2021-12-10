<?php

namespace Modules\Api\Transformers;

use App\Models\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    public function transform(Question $question)
    {
        return [
            'serialNo' => $question->serial_no,
            'title' => $question->title_name,
            'content' => $question->contents,
        ];
    }
}
