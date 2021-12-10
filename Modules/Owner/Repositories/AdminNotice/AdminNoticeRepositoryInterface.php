<?php

namespace Modules\Owner\Repositories\AdminNotice;

use Modules\Owner\Repositories\RepositoryInterface;

interface AdminNoticeRepositoryInterface extends RepositoryInterface
{
    public function getNotifications($limit);
}
