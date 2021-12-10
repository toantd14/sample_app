<?php

namespace Modules\Admin\Repositories\Admin;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminRepositoryInterface extends RepositoryInterface
{
    public function getAdmin($request);
}
