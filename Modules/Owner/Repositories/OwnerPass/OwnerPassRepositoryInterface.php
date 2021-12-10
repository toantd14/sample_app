<?php

namespace Modules\Owner\Repositories\OwnerPass;

use Modules\Owner\Repositories\RepositoryInterface;

interface OwnerPassRepositoryInterface extends RepositoryInterface
{
    public function getOwner($request);
}
