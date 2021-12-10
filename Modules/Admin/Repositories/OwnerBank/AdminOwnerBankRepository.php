<?php

namespace Modules\Admin\Repositories\OwnerBank;

use App\Models\OwnerBank;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminOwnerBankRepository extends RepositoryAbstract implements AdminOwnerBankRepositoryInterface
{
    public function __construct(OwnerBank $ownerBank)
    {
        $this->model = $ownerBank;
    }

    public function getByOwnerCd($ownerCD)
    {
        return $this->model->where('owner_cd', $ownerCD)->get();
    }
}
