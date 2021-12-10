<?php

namespace Modules\Owner\Repositories\OwnerNotice;

use App\Models\OwnerNotice;
use Illuminate\Support\Facades\Auth;
use Modules\Owner\Repositories\RepositoryAbstract;

class OwnerNoticeRepository extends RepositoryAbstract implements OwnerNoticeRepositoryInterface
{
    public function __construct(OwnerNotice $ownerNotice)
    {
        $this->model = $ownerNotice;
    }

    public function getNotifications($limit)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;

        return $this->model->memberCd($ownerCd)
            ->latest()
            ->latest('notics_cd')
            ->paginate($limit);
    }

    public function checkEmptyNotice($parkingID)
    {
        return $this->model->where('parking_cd', $parkingID)->exists();
    }

    public function countListNotice($parkingID)
    {
        return $this->model->where('parking_cd', $parkingID)
            ->latest()
            ->get();
    }

    public function searchNotifications($dataSearch)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;

        return $this->model->memberCd($ownerCd)
            ->noticeTitle($dataSearch['title'])
            ->parkingCd($dataSearch['parking_cd'])
            ->searchByDate($dataSearch['date_public_from'], $dataSearch['date_public_to'])
            ->latest()
            ->paginate(config('constants.USE_NOTICE_PAGE_LIMIT'));
    }
}
