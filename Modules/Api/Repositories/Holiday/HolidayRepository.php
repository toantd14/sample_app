<?php

namespace Modules\Api\Repositories\Holiday;

use App\Models\Holiday;
use Modules\Api\Repositories\RepositoryAbstract;
use Modules\Api\Traits\ConvertTimeTraits;

class HolidayRepository extends RepositoryAbstract implements HolidayRepositoryInterface
{
    use ConvertTimeTraits;

    public function __construct(Holiday $model)
    {
        $this->model = $model;
    }

    public function checkHoliday($date) {
        $date = $this->replaceTime($date);
        $holiday = $this->model->where('date', $date)->first();

        return !empty($holiday);
    }
}
