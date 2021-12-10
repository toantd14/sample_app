<?php

namespace Modules\Api\Http\Requests\UseSituation;

use App\Models\UseSituation;
use Modules\Api\Http\Requests\BaseRequest;
use Modules\Api\Traits\RequestBookingCar;

class UseSituationRequest extends BaseRequest
{
    use RequestBookingCar;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $baseRules = [
            'parkingID' => 'required|int|min:1',
            'bookingTime.bookingType' => 'required|int|min:0|in:' . implode(',', config('constants.BOOKING_TYPE')),
            'bookingTime.startDate' => 'required|date_format:Y-m-d',
            'contract.contractorName' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable',
            'contract.contractID' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable|int|min:1',
            'contract.prefectures' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable',
            'contract.municipality' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable',
            'contract.townname' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable',
            'customerInfo.customerType' => 'required|int|min:0|in:' . implode(',', config('constants.CUSTOMER_TYPE')),
            'customerInfo.carNo' => 'required',
            'customerInfo.carType' => 'required',
            'customerInfo.firstName' => 'required_if:customerInfo.customerType,' . UseSituation::INDIVIDUAL . '|nullable',
            'customerInfo.lastName' => 'required_if:customerInfo.customerType,' . UseSituation::INDIVIDUAL . '|nullable',
            'customerInfo.firstNameKana' => 'required_if:customerInfo.customerType,' . UseSituation::INDIVIDUAL . '|nullable',
            'customerInfo.lastNameKana' => 'required_if:customerInfo.customerType,' . UseSituation::INDIVIDUAL . '|nullable',
            'customerInfo.phoneNumber' => 'required',
            'contract.telPhone' => 'required_if:bookingTime.bookingType,' . UseSituation::RENT_BY_MONTH . '|required_if:customerInfo.bookingType,' . UseSituation::RENT_BY_PERIOD . '|nullable',
            'paymentInfo.paymentType' => 'required|int|min:0|in:' . implode(',', config('constants.PAYMENT_TYPE')),
            'paymentInfo.paymentToken' => 'required_if:paymentInfo.paymentType,' . UseSituation::COMBINI . '|required_if:paymentInfo.paymentType,' . UseSituation::CREDIT_CARD,
            'paymentInfo.paymentPhoneNumber' => 'required_if:paymentInfo.paymentType,' . UseSituation::COMBINI . '|nullable',
        ];

        if (request()->paymentInfo['paymentType'] == UseSituation::BILL_CORPORATION) {
            $baseRules['customerInfo.customerType'] = 'required|int|min:0|in:' . UseSituation::CORPORATION;
        }

        $bookingTime = $this->requestBookingCar(request()->bookingTime);
        $baseRules = array_merge($baseRules, $bookingTime);
        return $baseRules;
    }
}
