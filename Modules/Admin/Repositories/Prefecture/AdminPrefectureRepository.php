<?php

namespace Modules\Admin\Repositories\Prefecture;

use App\Models\Prefecture;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminPrefectureRepository extends RepositoryAbstract implements AdminPrefectureRepositoryInterface
{
    public function __construct(Prefecture $model)
    {
        $this->model = $model;
    }

    public function getByName($name)
    {
        return $this->model->name($name)->first();
    }
}
