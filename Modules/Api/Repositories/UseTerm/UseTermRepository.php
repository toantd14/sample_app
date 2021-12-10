<?php

namespace Modules\Api\Repositories\UseTerm;
use App\Models\UseTerm;
use Modules\Api\Repositories\RepositoryAbstract;

class UseTermRepository extends RepositoryAbstract implements UseTermRepositoryInterface
{
    public function __construct(UseTerm $model)
    {
        $this->model = $model;
    }

    public function getUseTerm()
    {
        return $this->model->orderBy('serial_no','DESC')->first();
    }
}
