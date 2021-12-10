<?php

namespace Modules\Owner\Repositories\Owner;

use Modules\Owner\Repositories\RepositoryInterface;

interface OwnerRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCdAndCertificationCd($ownerCd, $certificationCd);

    public function updateCertificationResult($ownerCd, $certificationCd, $certificationResult);

    public function getByOwnerCd($ownerCd);

    public function searchOwner($params);

    public function checkCertificationAndDelFfg($email);

    public function checkEmailExits($email, $ownerId);
}
