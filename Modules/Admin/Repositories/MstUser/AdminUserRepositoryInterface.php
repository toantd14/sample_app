<?php

namespace Modules\Admin\Repositories\MstUser;

use Modules\Owner\Repositories\RepositoryInterface;


interface AdminUserRepositoryInterface extends RepositoryInterface
{
   public function getByUserCdAndCertificationCd($ownerCd, $certificationCd);

   public function searchUser($params);

   public function checkCertificationAndDelFfg($email);

   public function checkEmailExits($email, $userCd);
}
