<?php

namespace Modules\Admin\Repositories\Owner;

use App\Models\Owner;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminOwnerRepository extends RepositoryAbstract implements AdminOwnerRepositoryInterface
{
    public function __construct(Owner $owner)
    {
        $this->model = $owner;
    }

    public function getByOwnerCdAndCertificationCd($ownerCd, $certificationCd)
    {
        return $this->model->ownerCd($ownerCd)->certificationCd($certificationCd)->first();
    }

    public function updateCertificationResult($ownerCd, $certificationCd, $certificationResult)
    {
        $data = [
            'certification_result' => $certificationResult
        ];

        return $this->model->certificationCd($certificationCd)
            ->update($data);
    }

    public function getByOwnerCd($ownerCd)
    {
        return $this->model->ownerCd($ownerCd)->first();
    }
}
