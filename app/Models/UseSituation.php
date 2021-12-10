<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Owner\Http\Traits\ResponseTraits;
use Symfony\Component\HttpFoundation\Response;

class UseSituation extends Model
{
    use SoftDeletes;
    use ConvertTimeTraits;
    use ResponseTraits;

    const RENT_BY_MONTH = 0;
    const RENT_BY_PERIOD = 1;
    const RENT_BY_HOUR = 2;
    const RENT_BY_DAY = 3;

    const RENTS = [
        0 => '月貸し',
        1 => '期間貸し',
        2 => '時間貸し',
        3 => '日貸し',
    ];

    const RESERVE = 0; // đặt qua app luôn là đặt trước
    const USE = 1; // đến đặt trực tiếp là sử dụng

    const RESERVE_USE = [
        0 => '月単位',
        1 => '度都',
    ];

    const CREDIT_CARD = 0;
    const COMBINI = 1;
    const BILL_CORPORATION = 2; // Hóa đơn yêu cầu thanh toán corporation

    const TYPE_CHECKOUT = [
        null => '',
        0 => 'クレジット',
        1 => 'コンビニ',
        2 => '法人請求書',
    ];

    const INDIVIDUAL = 0;
    const CORPORATION = 1;

    const RESERVATION = 0; //Đặt trước
    const USE_KBN = 1; //Sử dụng

    const CREDIT_PAYMENT = 0;
    const CONVENIENCE_STORE_PAYMENT = 1;
    const CORPORATE_INVOICE_PAYMENT = 2;

    protected $table = 'tbl_use_situation';
    protected $primaryKey = 'receipt_number';
    protected $fillable = [
        'receipt_number',
        'user_cd',
        'owner_cd',
        'parking_cd',
        'parking_spacecd',
        'parking_menucd',
        'visit_no',
        'reservation_use_kbn',
        'contract_id',
        'reservation_day',
        'use_day',
        'from_reservation_time',
        'to_reservation_time',
        'putin_time',
        'putout_time',
        'start_day',
        'end_day',
        'period_month',
        'usetime_from',
        'usetime_to',
        'car_type_reservation',
        'car_no_reservation',
        'car_type_performance',
        'car_no_performance',
        'space_symbol',
        'space_no',
        'name_sei',
        'name_mei',
        'name_seikana',
        'name_meikana',
        'company_name',
        'department',
        'person_man',
        'tel_no',
        'division',
        'payment_division_reservation',
        'payment_division',
        'money_reservation',
        'conveni',
        'conveni_paymentno',
        'combined_division',
        'settlement_id',
        'conveni_day',
        'parking_fee',
        'discount_rates',
        'combined_point',
        'payment',
        'grant_points',
        'payment_day',
        'registered_person',
        'updater',
        'created_at',
    ];

    public function parkingLot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_cd', 'parking_cd');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'receipt_number', 'receipt_number');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'receipt_number', 'receipt_number');
    }

    public function scopeUseYear($query, $year)
    {
        $query->when($year, function ($query) use ($year) {
            return $query->whereYear('use_day', $year);
        });
    }

    public function scopeUseMonth($query, $month)
    {
        $query->when($month, function ($query) use ($month) {
            return $query->whereMonth('use_day', $month);
        });
    }

    public function scopeUseDay($query, $dayUseFrom, $dayUseTo)
    {
        $query->when($dayUseFrom, function ($query) use ($dayUseFrom) {
            return $query->whereDate('use_day', '>=', $dayUseFrom);
        });

        $query->when($dayUseTo, function ($query) use ($dayUseTo) {
            return $query->whereDate('use_day', '<=', $dayUseTo);
        });
    }

    public function scopeParkingCd($query, $parkingCd)
    {
        $query->when($parkingCd, function ($query) use ($parkingCd) {
            return $query->where('parking_cd', $parkingCd);
        });
    }

    public function scopeReservationDay($query, $reservationDayFrom, $reservationDayTo)
    {
        $query->when($reservationDayFrom, function ($query) use ($reservationDayFrom) {
            return $query->whereDate('reservation_day', '>=', $reservationDayFrom);
        });

        $query->when($reservationDayTo, function ($query) use ($reservationDayTo) {
            return $query->whereDate('reservation_day', '<=', $reservationDayTo);
        });
    }

    public function scopePaymentDay($query, $paymentDayFrom, $paymentDayTo)
    {
        $query->when($paymentDayFrom, function ($query) use ($paymentDayFrom) {
            return $query->whereDate('payment_day', '>=', $paymentDayFrom);
        });

        $query->when($paymentDayTo, function ($query) use ($paymentDayTo) {
            return $query->whereDate('payment_day', '<=', $paymentDayTo);
        });
    }

    public function scopeVisitNo($query, $visitNo)
    {
        $query->when(isset($visitNo), function ($query) use ($visitNo) {
            return $query->where('visit_no', '=', $visitNo);
        });
    }

    public function scopeReservationUseKbn($query, $reservationUseKbn)
    {
        $query->when(isset($reservationUseKbn), function ($query) use ($reservationUseKbn) {
            return $query->where('reservation_use_kbn', $reservationUseKbn);
        });
    }

    public function scopePaymentDivision($query, $paymentDivision)
    {
        $query->when(isset($paymentDivision), function ($query) use ($paymentDivision) {
            return $query->where('payment_division', $paymentDivision);
        });
    }

    public function scopeSearchOwnerCd($query, $ownerCd)
    {
        $query->when(isset($ownerCd), function ($query) use ($ownerCd) {
            return $query->where('owner_cd', $ownerCd);
        });
    }

    public function scopeOwnerCd($query, $ownerCd)
    {
        return $query->where('owner_cd', $ownerCd);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_cd', 'owner_cd');
    }

    public function uniqueUserName()
    {
        if ($this->division == UseSituation::CORPORATION) {
            return $this->company_name . '御中';
        }

        return $this->name_sei . $this->name_mei . '様';
    }

    public function uniqueUserTimeUseTo()
    {
        if ($this->use_day) {
            return formatDateString($this->use_day, 'm/d');
        }

        return formatDateString($this->start_day, 'm/d');
    }

    public function deadlinePay()
    {
        if ($this->use_day) {
            return $this->handleDeadlineDateTime($this->use_day);
        }

        return $this->handleDeadlineDateTime($this->start_day);
    }

    public function handleDeadlineDateTime($date)
    {
        if ($date instanceof \Carbon\Carbon) {
            $date = $date->subDay(config('constants.TRANSFER_BEFORE_DATE'));

            return $date->format('m月d日');
        }

        if (preg_match(config('constants.STRING_YYYY/MM/DD'), $date)) {
            $useDay = new Carbon($date);
            $useDay = $useDay->subDay(config('constants.TRANSFER_BEFORE_DATE'));

            return $useDay->format('m月d日');
        }

        return $date;
    }

    public function getReservationDate()
    {
        return ($this->visit_no == self::RENT_BY_PERIOD || $this->visit_no == self::RENT_BY_MONTH) ? $this->reservation_day : $this->start_day;
    }

    public function getErrorCodeDefine()
    {
        return [
            config('constants.STATUS_FLAG_TIME.PRIVATE'),
            config('constants.CHECK_DATE_LESS_NOW'),
            config('constants.CHECK_DATE_FIT'),
            config('constants.CHECK_MINIMUM_USE'),
            config('constants.CHECK_HOUR_LESS_NOW'),
            config('constants.CHECK_PRICE_GREATER_ZERO'),
            config('constants.CHECK_WEEKDAY_FIT'),
            config('constants.STATUS_FLAG_TIME.MONTH'),
            config('constants.STATUS_FLAG_TIME.DATE'),
            config('constants.STATUS_FLAG_TIME.PERIOD'),
            config('constants.STATUS_FLAG_TIME.HOUR')
        ];
    }

    public function getErrorMessagePayment($ec)
    {
        $ec = substr($ec, config('payment.start_sub_string'));
        $errorMessage = config('payment.error_message');

        if (isset($errorMessage[$ec]))
            return $errorMessage[$ec];

        return trans('message.payment.error');
    }

    public function getTimeFlag($parkingMenu)
    {
        return [
            'month_flg' => $parkingMenu['month_flg'],
            'period_flg' => $parkingMenu['period_flg'],
            'day_flg' => $parkingMenu['day_flg'],
            'time_flg' => $parkingMenu['time_flg'],
        ];
    }

    public function getSalesTime($parkingLot)
    {
        return [
            'sales_division' => $parkingLot['sales_division'],
            'sales_start_time' => $parkingLot['sales_start_time'],
            'sales_end_time' => $parkingLot['sales_end_time'],
        ];
    }
}
