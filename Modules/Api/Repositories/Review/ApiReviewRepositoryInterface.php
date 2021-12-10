<?php

namespace Modules\Api\Repositories\Review;

use Modules\Api\Repositories\RepositoryInterface;

interface ApiReviewRepositoryInterface extends RepositoryInterface
{
    public function getLatestBySerialNo();

    public function getReviewOfUser($parkingCd);

    public function isUserCreated($userId, $reviewId);
}
