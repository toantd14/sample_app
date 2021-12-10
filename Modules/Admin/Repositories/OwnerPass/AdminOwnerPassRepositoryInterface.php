<?php

namespace Modules\Admin\Repositories\OwnerPass;

use Modules\Owner\Repositories\RepositoryInterface;

interface AdminOwnerPassRepositoryInterface extends RepositoryInterface
{
    public function getOwner($request);
}
