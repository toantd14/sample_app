<?php

namespace Modules\Admin\Http\Exports;

use App\Models\UseSituation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Admin\Repositories\UseSituation\AdminUseSituationRepositoryInterface;

class TimeUsedExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $adminUseSituationRepository;
    protected $params;
    private $count = 1;

    public function __construct(AdminUseSituationRepositoryInterface $adminUseSituationRepository, $params)
    {
        $this->adminUseSituationRepository = $adminUseSituationRepository;
        $this->params = $params;
    }

    public function collection()
    {
        return $this->adminUseSituationRepository->search($this->params);
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
        if (isset(UseSituation::RENTS[$useSituation->visit_no])) {
            return UseSituation::RENTS[$useSituation->visit_no];
        }

        return '';
    }

    public function getUseKubun($useSituation)
    {
        if (isset(UseSituation::RENTS[$useSituation->reservation_use_kbn])) {
            return UseSituation::RENTS[$useSituation->reservation_use_kbn];
        }

        return '';
    }

    public function getPaymentDivision($useSituation)
    {
        if (isset(UseSituation::TYPE_CHECKOUT[$useSituation->payment_division])) {
            return UseSituation::TYPE_CHECKOUT[$useSituation->payment_division];
        }

        return '';
    }
}
