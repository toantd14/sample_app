<?php

namespace Modules\Api\Repositories\LoginToken;

use Modules\Api\Repositories\RepositoryInterface;

interface LoginTokenRepositoryInterface extends RepositoryInterface
{
    public function getByEmailMstUser($email);

    public function updateByUserCd($userCd, $dataUpdate);
}
