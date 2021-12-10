<?php

namespace Modules\Api\Repositories\QuestionCategory;

use App\Models\QuestionCategory;
use Modules\Api\Repositories\RepositoryAbstract;

class ApiQuestionCategoryRepository extends RepositoryAbstract implements ApiQuestionCategoryRepositoryInterface
{
    protected $model;

    public function __construct(QuestionCategory $model)
    {
        $this->model = $model;
    }

    public function getNewQuestionCategories()
    {
        return $this->model->latest()->take($this->model::MAX_RESOURCE_RESULT)->get();
    }
}
