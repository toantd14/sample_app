<?php


namespace Modules\Api\Repositories\Holiday;


use Modules\Api\Repositories\RepositoryInterface;

interface HolidayRepositoryInterface extends RepositoryInterface
{
    public function checkHoliday($date);
}
