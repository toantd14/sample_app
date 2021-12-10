<?php

namespace Modules\Api\Repositories\UseTerm;

use Modules\Api\Repositories\RepositoryInterface;

interface UseTermRepositoryInterface extends RepositoryInterface
{
    public function getUseTerm();
}
