<?php

namespace Modules\Api\Repositories\ContractTemplate;

use App\Models\ContractTemplate;
use Modules\Api\Repositories\RepositoryAbstract;

class ContractTemplateRepository extends RepositoryAbstract implements ContractTemplateRepositoryInterface
{
    public function __construct(ContractTemplate $model)
    {
        $this->model = $model;
    }

    public function getContractTemplate()
    {
        return $this->model->orderBy('serial_no', 'DESC')->first();
    }
}
