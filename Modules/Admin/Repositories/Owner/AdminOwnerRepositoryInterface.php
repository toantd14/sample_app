<?php

namespace Modules\Admin\Repositories\Owner;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminOwnerRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCdAndCertificationCd($ownerCd, $certificationCd);

    public function updateCertificationResult($ownerCd, $certificationCd, $certificationResult);

    public function getByOwnerCd($ownerCd);

}
