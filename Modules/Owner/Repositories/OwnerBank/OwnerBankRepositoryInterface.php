<?php

namespace Modules\Owner\Repositories\OwnerBank;

use Modules\Owner\Repositories\RepositoryInterface;

interface OwnerBankRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($ownerCd);
}
