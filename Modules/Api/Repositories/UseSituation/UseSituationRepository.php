<?php

namespace Modules\Api\Repositories\UseSituation;

use App\Models\UseSituation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Api\Repositories\RepositoryAbstract;
use Modules\Api\Services\PaymentService;

class UseSituationRepository extends RepositoryAbstract implements UseSituationRepositoryInterface
{
    protected $paymentService;

    public function __construct(UseSituation $model, PaymentService $paymentService)
    {
        $this->model = $model;
        $this->paymentService = $paymentService;
    }

    public function payment($arrParams)
    {
        return $this->paymentService->payment($arrParams);
    }

    public function getLatestReceiptNumber () {
        $parkingMenu = $this->model->latest()->first();
        return $parkingMenu->receipt_number;
    }
    public function getBookingHistory($pageSize) {
        $select = [
            'receipt_number as bookingID',
            'visit_no as bookingType',
            'tbl_use_situation.parking_cd as parkingID',
            'parking_name as parkingName',
            DB::raw('DATE_FORMAT(use_day, "%Y-%m-%d") as useDay'),
            DB::raw('DATE_FORMAT(start_day, "%Y-%m-%d") as start_day'),
            DB::raw('DATE_FORMAT(reservation_day, "%Y-%m-%d") as reservation_day'),
            'usetime_from as useFromTime',
            'usetime_to as useToTime',
            DB::raw('(payment + combined_point) as paymentPrice'),
            'use_day',
            'usetime_from',
            'usetime_to',
            'parking_fee',
            'division',
            'visit_no',
            'from_reservation_time',
            'to_reservation_time',
            'money_reservation',
            'putin_time',
            'putout_time',
            'combined_point'
        ];

        $userLogged = Auth::user();

        return $this->model
            ->select($select)
            ->where('user_cd', $userLogged->user_cd)
            ->join('tbl_parking_lot', 'tbl_parking_lot.parking_cd', 'tbl_use_situation.parking_cd' )
            ->latest('bookingID')
            ->paginate($pageSize);
    }

    public function findOrFail($bookingID)
    {
        return $this->model->findOrFail($bookingID);
    }
}

