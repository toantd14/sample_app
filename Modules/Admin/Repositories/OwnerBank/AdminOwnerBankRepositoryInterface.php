<?php

namespace Modules\Admin\Repositories\OwnerBank;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminOwnerBankRepositoryInterface extends RepositoryInterface
{
    public function getByOwnerCd($ownerCd);
}
