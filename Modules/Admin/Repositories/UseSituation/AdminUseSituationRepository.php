<?php

namespace Modules\Admin\Repositories\UseSituation;

use App\Models\UseSituation;
use Modules\Owner\Repositories\RepositoryAbstract;

class AdminUseSituationRepository extends RepositoryAbstract implements AdminUseSituationRepositoryInterface
{
    public function __construct(UseSituation $useSituation)
    {
        $this->model = $useSituation;
    }

    public function getAll()
    {
        return $this->model->with('parkingLot')->latest('receipt_number')->paginate(config('constants.USE_SITUATION_PAGE_LIMIT'));
    }

    public function search($dataSearch)
    {
        $useSituations = $this->model->with('parkingLot')
            ->UseYear($dataSearch['year'] ?? null)
            ->UseMonth($dataSearch['month'] ?? null)
            ->UseDay($dataSearch['use_day_from'] ?? null, $dataSearch['use_day_to'] ?? null)
            ->SearchOwnerCd($dataSearch['owner_cd'] ?? null)
            ->ParkingCd($dataSearch['parking_lot'] ?? null)
            ->ReservationDay($dataSearch['reservation_day_from'] ?? null, $dataSearch['reservation_day_to'] ?? null)
            ->VisitNo($dataSearch['visit_no'] ?? null)
            ->PaymentDivision($dataSearch['payment_division'] ?? null)
            ->PaymentDay($dataSearch['payment_day_from'] ?? null, $dataSearch['payment_day_to'] ?? null)
            ->latest();

        if (request()->routeIs('admin.export.use.situation')) {
            return $useSituations->get();
        } else {
            return $useSituations->paginate(config('constants.USE_SITUATION_PAGE_LIMIT'));
        }
    }
}
