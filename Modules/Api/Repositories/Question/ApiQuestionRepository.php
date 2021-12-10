<?php

namespace Modules\Api\Repositories\Question;

use App\Models\Question;
use Modules\Api\Repositories\RepositoryAbstract;

class ApiQuestionRepository extends RepositoryAbstract implements ApiQuestionRepositoryInterface
{
    protected $model;

    public function __construct(Question $model)
    {
        $this->model = $model;
    }

    public function getQuestionsByCategory($questionCategoryId, $pageSize)
    {
        return $this->model->where('category_id', $questionCategoryId)->latest()->paginate($pageSize);
    }
}
