<?php

namespace Modules\Api\Repositories\MstUser;

use Modules\Api\Repositories\RepositoryInterface;

interface MstUserRepositoryInterface extends RepositoryInterface
{
    public function findByFacebookId($facebookId);

    public function generateNewUserID();

    public function findByLineId($lineId);

    public function findByGoogleId($googleId);

    public function findOrCreateUser($dataUser, $howtoUse);
}
