<?php

namespace Modules\Owner\Repositories\MstUser;

use Modules\Owner\Repositories\RepositoryInterface;


interface UserRepositoryInterface extends RepositoryInterface
{
   public function getByUserCdAndCertificationCd($ownerCd, $certificationCd);

   public function searchUser($params);

   public function checkCertificationAndDelFfg($email);

   public function checkEmailExits($email, $userCd);
}
