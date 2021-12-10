<?php

namespace Modules\Owner\Repositories\AdminNotice;

use App\Models\AdminNotice;
use Illuminate\Support\Facades\Auth;
use Modules\Owner\Repositories\RepositoryAbstract;

class AdminNoticeRepository extends RepositoryAbstract implements AdminNoticeRepositoryInterface
{
    public function __construct(AdminNotice $adminNotice)
    {
        $this->model = $adminNotice;
    }

    public function getNotifications($limit)
    {
        return $this->model
            ->orderBy('created_at', config('constants.TYPE_SORT.DESCENDING'))
            ->paginate($limit);
    }
}
