<?php

namespace Modules\Owner\Repositories\Auth;

use Modules\Owner\Repositories\RepositoryInterface;


interface AuthRepositoryInterface extends RepositoryInterface
{
   public function store($data);
}
