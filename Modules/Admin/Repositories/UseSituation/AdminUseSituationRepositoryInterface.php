<?php

namespace Modules\Admin\Repositories\UseSituation;

use Modules\Owner\Repositories\RepositoryInterface;

interface AdminUseSituationRepositoryInterface extends RepositoryInterface
{
    public function getAll();

    public function search($dataSearch);
}
