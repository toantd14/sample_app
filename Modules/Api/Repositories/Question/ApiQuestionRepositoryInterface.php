<?php

namespace Modules\Api\Repositories\Question;

use Modules\Api\Repositories\RepositoryInterface;

interface ApiQuestionRepositoryInterface extends RepositoryInterface
{
    public function getQuestionsByCategory($questionCategoryId, $pageSize);
}
