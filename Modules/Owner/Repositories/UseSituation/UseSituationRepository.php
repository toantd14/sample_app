<?php

namespace Modules\Owner\Repositories\UseSituation;

use App\Models\UseSituation;
use Illuminate\Support\Facades\Auth;
use Modules\Owner\Repositories\RepositoryAbstract;

class UseSituationRepository extends RepositoryAbstract implements UseSituationRepositoryInterface
{
    public function __construct(UseSituation $useSituation)
    {
        $this->model = $useSituation;
    }

    public function find($receiptNumber)
    {
        return $this->model->with('parkingLot')->find($receiptNumber);
    }

    public function getAll($ownerCd)
    {
        return $this->model->latest('receipt_number')->ownerCd($ownerCd)->with('parkingLot')->paginate(config('constants.USE_SITUATION_PAGE_LIMIT'));
    }

    public function search($dataSearch)
    {
        return $this->model->with('parkingLot')
            ->OwnerCd(Auth::guard('owner')->user()->owner_cd)
            ->UseYear($dataSearch['year'])
            ->UseMonth($dataSearch['month'])
            ->UseDay($dataSearch['use_day_from'], $dataSearch['use_day_to'])
            ->ParkingCd($dataSearch['parking_lot'])
            ->ReservationDay($dataSearch['reservation_day_from'], $dataSearch['reservation_day_to'])
            ->VisitNo($dataSearch['visit_no'])
            ->ReservationUseKbn($dataSearch['reservation_use_kbn'])
            ->PaymentDivision($dataSearch['payment_division'])
            ->PaymentDay($dataSearch['payment_day_from'], $dataSearch['payment_day_to']);
    }
}
