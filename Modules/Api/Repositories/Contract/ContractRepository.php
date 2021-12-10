<?php

namespace Modules\Api\Repositories\Contract;
use App\Models\Contract;
use Modules\Api\Repositories\RepositoryAbstract;

class ContractRepository extends RepositoryAbstract implements ContractRepositoryInterface
{
    public function __construct(Contract $model)
    {
        $this->model = $model;
    }
}
