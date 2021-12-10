<?php

namespace Modules\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Review;

class UserReviewTransformer extends TransformerAbstract
{
    public function transform(Review $review)
    {
        return [
            'reviewID' => $review->serial_no,
            'satisfation' => $review->evaluation_satisfaction,
            'location' => $review->evaluation_location,
            'easeStopping' => $review->evaluation_ease_stopping,
            'fee' => $review->evaluation_fee,
            'comment' => $review->comment,
        ];
    }
}
