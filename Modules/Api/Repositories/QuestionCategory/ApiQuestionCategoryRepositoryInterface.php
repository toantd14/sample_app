<?php

namespace Modules\Api\Repositories\QuestionCategory;

use Modules\Api\Repositories\RepositoryInterface;

interface ApiQuestionCategoryRepositoryInterface extends RepositoryInterface
{
    public function getNewQuestionCategories();
}
