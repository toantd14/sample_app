<?php

namespace Modules\Api\Repositories\ContractTemplate;

use Modules\Api\Repositories\RepositoryInterface;

interface ContractTemplateRepositoryInterface extends RepositoryInterface
{
    public function getContractTemplate();
}
