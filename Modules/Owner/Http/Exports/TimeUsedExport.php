<?php

namespace Modules\Owner\Http\Exports;

use App\Models\UseSituation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Owner\Repositories\UseSituation\UseSituationRepositoryInterface;

class TimeUsedExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $useSituationRepository;
    protected $params;
    private $count = 1;

    public function __construct(UseSituationRepositoryInterface $useSituationRepository, $params)
    {
        $this->useSituationRepository = $useSituationRepository;
        $this->params = $params;
    }

    public function collection()
    {
        return $this->useSituationRepository->search($this->params)->get();
    }

    public function headings(): array
    {
        return [
            __('message.time_used.no'),
            __('message.time_used.parking_name'),
            __('message.time_used.created_at'),
            __('message.time_used.reservation_day'),
            __('message.time_used.car_no_performance'),
            __('message.time_used.visit_no'),
            __('message.time_used.reservation_use_kbn'),
            __('message.time_used.payment_division')
        ];
    }

    public function map($useSituation): array
    {
        return [
            $this->count++,
            $useSituation->parkingLot->parking_name,
            Carbon::parse($useSituation->parkingLot->created_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST')),
            $useSituation->reservation_day,
            $useSituation->car_no_performance,
            $this->getVisitNo($useSituation),
            $this->getUseKubun($useSituation),
            $this->getPaymentDivision($useSituation)
        ];
    }

    public function getVisitNo($useSituation)
    {
        if( $useSituation->visit_no === UseSituation::RENT_BY_MONTH)
            return '月貸し';
        elseif( $useSituation->visit_no === UseSituation::RENT_BY_PERIOD)
            return '期間貸し';
        elseif( $useSituation->visit_no === UseSituation::RENT_BY_HOUR)
            return '時間貸し';
        elseif( $useSituation->visit_no === UseSituation::RENT_BY_DAY)
            return '日貸し';
        return '';
    }

    public function getUseKubun($useSituation)
    {
        if( $useSituation->reservation_use_kbn === UseSituation::RESERVE)
            return '月単位';
        elseif( $useSituation->reservation_use_kbn === UseSituation::USE)
            return '度都';
        return '';
    }

    public function getPaymentDivision($useSituation)
    {
        if( $useSituation->payment_division === UseSituation::CREDIT_CARD)
            return 'クレジット';
        elseif( $useSituation->payment_division === UseSituation::COMBINI)
            return '電子マネー';
        elseif( $useSituation->payment_division === UseSituation::BILL_CORPORATION)
            return '請求書';
        return '';
    }
}
