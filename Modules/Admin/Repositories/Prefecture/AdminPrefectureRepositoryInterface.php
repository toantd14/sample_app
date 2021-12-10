<?php

namespace Modules\Admin\Repositories\Prefecture;

use Modules\Admin\Repositories\RepositoryInterface;

interface AdminPrefectureRepositoryInterface extends RepositoryInterface
{
    public function getByName($name);
}
