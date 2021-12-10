<?php

namespace Modules\Api\Repositories\LoginToken;

use App\Models\LoginToken;
use Modules\Api\Repositories\RepositoryAbstract;

class LoginTokenRepository extends RepositoryAbstract implements LoginTokenRepositoryInterface
{
    protected $model;

    public function __construct(LoginToken $model)
    {
        $this->model = $model;
    }

    public function getByEmailMstUser($email)
    {
        return $this->model
            ->leftJoin('mst_user', 'login_tokens.user_cd', 'mst_user.user_cd')
            ->select('login_tokens.*')
            ->first();
    }

    public function updateByUserCd($userCd, $dataUpdate)
    {
        return $this->model->userCd($userCd)->update($dataUpdate);
    }

    public function findByRefreshToken($refreshToken)
    {
        return $this->model->refreshToken($refreshToken)->first();
    }
}
