<?php

namespace Modules\Owner\Repositories\UseSituation;

use Modules\Owner\Repositories\RepositoryInterface;

interface UseSituationRepositoryInterface extends RepositoryInterface
{
    public function find($receiptNumber);

    public function getAll($ownerCd);

    public function search($dataSearch);
}
