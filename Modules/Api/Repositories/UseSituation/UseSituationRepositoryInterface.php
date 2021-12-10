<?php

namespace Modules\Api\Repositories\UseSituation;

use Modules\Api\Repositories\RepositoryInterface;

interface UseSituationRepositoryInterface extends RepositoryInterface
{
    public function payment($arrParams);
    public function getBookingHistory($pageSize);
    public function findOrFail($bookingID);
}
