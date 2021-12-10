<?php

namespace Modules\Owner\Repositories\Prefecture;

use Modules\Owner\Repositories\RepositoryInterface;

interface PrefectureRepositoryInterface extends RepositoryInterface
{
    public function getByName($name);
}
