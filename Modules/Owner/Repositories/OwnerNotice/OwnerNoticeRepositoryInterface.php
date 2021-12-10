<?php

namespace Modules\Owner\Repositories\OwnerNotice;

use Modules\Owner\Repositories\RepositoryInterface;

interface OwnerNoticeRepositoryInterface extends RepositoryInterface
{
    public function getNotifications($limit);

    public function searchNotifications($dataSearch);

    public function countListNotice($parkingID);
}

