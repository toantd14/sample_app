<?php

namespace Modules\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Review;

class ReviewTransformer extends TransformerAbstract
{
    public function transform(Review $review) 
    {
        return [
            'userID' => $review->user_cd,
            'userName' => $this->getFullName($review),
            'comment' => $review->comment,
            'createdAt' => $review->created_at->format('Y-m-d\TH:m:sP'),
            'evaluation' => $this->getEvaluationPerReview($review),
        ];
    }

    public function getFullName(Review $review)
    {
        return $review->mstUser->name_sei.' '.$review->mstUser->name_mei;
    }

    public function getEvaluationPerReview(Review $review)
    {
        $avg = [
            $review->evaluation_satisfaction,
            $review->evaluation_location,
            $review->evaluation_ease_stopping,
            $review->evaluation_fee
        ];

        return array_sum($avg) / count($avg);
    }
}
