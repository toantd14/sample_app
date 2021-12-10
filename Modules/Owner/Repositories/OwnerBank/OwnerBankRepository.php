<?php

namespace Modules\Owner\Repositories\OwnerBank;

use App\Models\OwnerBank;
use Modules\Owner\Repositories\RepositoryAbstract;

class OwnerBankRepository extends RepositoryAbstract implements OwnerBankRepositoryInterface
{
    public function __construct(OwnerBank $ownerBank)
    {
        $this->model = $ownerBank;
    }

    public function getByOwnerCd($ownerCd)
    {
        return $this->model->where('owner_cd', $ownerCd)->first();
    }
}
