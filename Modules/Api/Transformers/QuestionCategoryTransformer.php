<?php

namespace Modules\Api\Transformers;

use App\Models\OwnerNotice;
use App\Models\QuestionCategory;
use League\Fractal\TransformerAbstract;
use Modules\Api\Traits\ConvertTimeTraits;

class QuestionCategoryTransformer extends TransformerAbstract
{
    public function transform(QuestionCategory $questionCategory)
    {
        return [
            'categoryID' => (string) $questionCategory->category_id,
            'categoryName' => $questionCategory->category_name,
        ];
    }
}
