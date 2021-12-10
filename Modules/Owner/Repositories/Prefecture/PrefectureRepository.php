<?php

namespace Modules\Owner\Repositories\Prefecture;

use App\Models\Prefecture;
use Modules\Owner\Repositories\RepositoryAbstract;

class PrefectureRepository extends RepositoryAbstract implements PrefectureRepositoryInterface
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
