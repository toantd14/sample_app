<?php

namespace Modules\Api\Repositories\Review;

use App\Exceptions\UserCreatedException;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Repositories\RepositoryAbstract;

class ApiReviewRepository extends RepositoryAbstract implements ApiReviewRepositoryInterface
{
    protected $model;

    public function __construct(Review $model)
    {
        $this->model = $model;
    }

    public function getLatestBySerialNo()
    {
        return $this->model->latest('serial_no')->first();
    }

    public function getReviewOfUser($parkingCd)
    {
        return $this->model
            ->parkingCd($parkingCd)
            ->userCd(Auth::guard('api')
                ->user()
                ->user_cd);
    }

    public function isUserCreated($userId, $reviewId)
    {
        return $this->model
            ->userCd($userId)
            ->find($reviewId);
    }

    public function update($id, $data)
    {
        $user = Auth::guard('api')->user();

        if (isset($user)) {
            if ($this->isUserCreated($user->user_cd, $id)) {
                return parent::update($id, $data);
            }
        }

        throw new UserCreatedException();
    }
}
