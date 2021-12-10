<?php

namespace Modules\Api\Http\Controllers;

use Modules\Api\Http\Requests\UseSituation\PDFPaymentBillingRequest;
use Modules\Api\Transformers\BookingHistoriesTransformer;
use PDF;
use Carbon\Carbon;
use App\Models\UseSituation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Owner\Http\Traits\ResponseTraits;
use Symfony\Component\HttpFoundation\Response;
use Modules\Api\Traits\ResponseServerErrorTrait;
use Modules\Api\Transformers\UseSituationTransformer;
use Modules\Owner\Repositories\MstUser\UserRepository;
use Modules\Api\Repositories\Holiday\HolidayRepository;
use Modules\Api\Repositories\Contract\ContractRepository;
use Modules\Api\Http\Requests\UseSituation\CalculateRequest;
use Modules\Owner\Repositories\Parking\ParkingLotRepository;
use Modules\Api\Http\Requests\UseSituation\UseBookingRequest;
use Modules\Api\Http\Requests\UseSituation\UseSituationRequest;
use Modules\Owner\Repositories\Prefecture\PrefectureRepository;
use Modules\Api\Http\Requests\UseSituation\BookingHistoryRequest;
use Modules\Api\Repositories\UseSituation\UseSituationRepository;
use Modules\Owner\Repositories\ParkingMenu\ParkingMenuRepository;
use Modules\Api\Repositories\ContractTemplate\ContractTemplateRepository;
use Modules\Owner\Repositories\ParkingMenuTime\ParkingMenuTimeRepository;

class UseSituationController extends Controller
{
    use ConvertTimeTraits;
    use ResponseTraits;
    use ResponseServerErrorTrait;

    protected $useSituationRepository;
    protected $parkingLotRepository;
    protected $parkingMenuRepository;
    protected $parkingMenuTimeRepository;
    protected $user;
    protected $userRepository;
    protected $contractRepository;
    protected $contractTemplateRepository;
    protected $prefectureRepository;
    protected $holidayRepository;
    protected $useSituation;

    public function __construct(
        UseSituationRepository $useSituationRepository,
        ParkingLotRepository $parkingLotRepository,
        ParkingMenuRepository $parkingMenuRepository,
        ParkingMenuTimeRepository $parkingMenuTimeRepository,
        UserRepository $userRepository,
        ContractRepository $contractRepository,
        ContractTemplateRepository $contractTemplateRepository,
        PrefectureRepository $prefectureRepository,
        HolidayRepository $holidayRepository,
        UseSituation $useSituation
    )
    {
        $this->useSituationRepository = $useSituationRepository;
        $this->parkingLotRepository = $parkingLotRepository;
        $this->parkingMenuRepository = $parkingMenuRepository;
        $this->parkingMenuTimeRepository = $parkingMenuTimeRepository;
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractTemplateRepository = $contractTemplateRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->holidayRepository = $holidayRepository;
        $this->useSituation = $useSituation;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('api')->user();

            return $next($request);
        });
    }

    public function checkEmptyParkingLotAndParkingMenu($parkingLot, $parkingMenu)
    {
        if (empty($parkingMenu) && empty($parkingLot)) {
            return false;
        }
        return true;
    }

    public function getParamParking($request, $parkingLot, $parkingMenu)
    {
        $userCd = $this->user->user_cd;
        $individual = $request['customerInfo']['customerType'] == UseSituation::INDIVIDUAL;
        $corporation = $request['customerInfo']['customerType'] == UseSituation::CORPORATION;

        return [
            'user_cd' => $userCd,
            'owner_cd' => $parkingLot ? $parkingLot->owner_cd : null,
            'parking_menucd' => $parkingMenu->menu_cd ?? null,
            //Thông tin đặt bãi đỗ xe
            'parking_cd' => $request['parkingID'],
            'visit_no' => $request['bookingTime']['bookingType'],
            'reservation_day' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_DAY ||
            $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_HOUR ? $this->replaceTime($request['bookingTime']['startDate']) : null,
            'start_day' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_MONTH ||
            $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_PERIOD ? $this->replaceTime($request['bookingTime']['startDate']) : null,
            'end_day' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_PERIOD ? $this->replaceTime($request['bookingTime']['endDate']) : null,
            'from_reservation_time' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_HOUR ? $request['bookingTime']['startTime'] : null,
            'putin_time' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_DAY ? $request['bookingTime']['startTime'] : null,
            'to_reservation_time' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_HOUR ? $request['bookingTime']['endTime'] : null,
            'period_month' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_MONTH ? $request['bookingTime']['month'] : null,
            //Thông tin customer
            'division' => $request['customerInfo']['customerType'],
            //Cá nhân
            'car_no_reservation' => $request['customerInfo']['carNo'],
            'car_type_reservation' => $request['customerInfo']['carType'],
            'tel_no' => $request['customerInfo']['phoneNumber'],
            'name_sei' => $individual ? $request['customerInfo']['firstName'] : null,
            'name_mei' => $individual ? $request['customerInfo']['lastName'] : null,
            'name_seikana' => $individual ? $request['customerInfo']['firstNameKana'] : null,
            'name_meikana' => $individual ? $request['customerInfo']['lastNameKana'] : null,
            //Công ty
            'company_name' => $corporation ? $request['customerInfo']['corporateName'] : null,
            'department' => $corporation ? $request['customerInfo']['departmentName'] : null,
            'person_man' => $corporation ? $request['customerInfo']['contactName'] : null,
            //Thanh toán
            'reservation_use_kbn' => UseSituation::RESERVE, //luôn là đặt trước
            'payment_division_reservation' => $request['paymentInfo']['paymentType'],
            //Combini
            'conveni' => $request['paymentInfo']['paymentType'] == UseSituation::COMBINI ? $request['paymentInfo']['paymentToken'] : null,
            //contract
            'contract_id' => $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_PERIOD ||
            $request['bookingTime']['bookingType'] == UseSituation::RENT_BY_MONTH ? $request['contract']['contractID'] : null
        ];
    }

    public function checkEmptyGetPriceByBookingType($request) {
        $price = $this->getPriceByBookingType($request);

        if (!$price) {
            return false;
        }

        return true;
    }

    public function handlingPayment($request, $params)
    {
        $price = $this->getPriceByBookingType($request);

        if (in_array($price['code'], $this->useSituation->getErrorCodeDefine())) {
            return $price;
        }

        $token = $request['paymentInfo']['paymentToken'];
        $arrPaymentInf = [
            'sid' => config('payment.sid'), //$arrData['shopId'],
            'svid' => config('payment.svid'), // Type of service
            'ptype' => config('payment.ptype'), // Type of processing
            'job' => config('payment.job'), // Type of Payment Job
            'rt' => config('payment.rt'), // Result Reply Method
            'upcmemberid' => $token, // Token
            'siam1' => intval($price['price']), // Price of product
        ];

        $payReturn = $this->useSituationRepository->payment($arrPaymentInf);
        // payment fail
        if (!$payReturn['status']) {
            return $payReturn['data'];
        }

        $arrPaymentRes = [
            'settlement_id' => $payReturn['data']['pid'],
            'money_reservation' => $payReturn['data']['ta'],
            'receipt_number' => Carbon::now()->format('Ymd') . $payReturn['data']['pid']
        ];
        $tokenUpdate = ($token == $this->user->token_key) ? '' : $token;
        $this->updateTokenKey($tokenUpdate);
        $params = array_merge($params, $arrPaymentRes);

        return [
            'code' => config('constants.STATUS_FLAG_TIME.PUBLIC'),
            'param' => $params
        ];
    }

    public function checkParametersRegisterParking($parameters, $request)
    {
        if ($this->checkEmptyGetPriceByBookingType($request)) {
            $errorMessage = trans('message.payment.error');
            Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_BAD_REQUEST);
        }

        if (
            isset($parameters['code']) && in_array($parameters['code'], $this->useSituation->getErrorCodeDefine())
        ) {
            $errorMessage = $parameters['message'];
            Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (empty($parameters)) {
            $errorMessage = trans('message.payment.error');

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_BAD_REQUEST);
        }

        if (isset($parameters['ec']) && $parameters['ec'] != config('payment.api_rst_success')) {
            $errorMessage = $this->useSituation->getErrorMessagePayment($parameters['ec']);

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_BAD_REQUEST);
        }
    }

    public function checkCalculationPriceParking($price, $request)
    {
        if (!$this->checkEmptyParkingMenu($request)) {
            $errorMessage = trans('message.parking_lot.not_exists');
            Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_NOT_FOUND);
        }

        if (in_array($price['code'], $this->useSituation->getErrorCodeDefine())) {
            $errorMessage = $price['message'];
            Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

            return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function validateContract($contractID)
    {
        $contractTemplate = $this->contractTemplateRepository->show($contractID);

        return !empty($contractTemplate);
    }

    protected function validatePrefecture($prefectures)
    {
        $prefectures = $this->prefectureRepository->getByName($prefectures);

        return !empty($prefectures);
    }

    public function registerParking(UseSituationRequest $request)
    {
        try {
            $parkingLot = $this->parkingLotRepository->find($request['parkingID']);
            $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request['parkingID']);
            $params = $this->getParamParking($request, $parkingLot, $parkingMenu);
            $checkContract = false;
            $checkPrefecture = false;

            if (!$this->checkEmptyParkingLotAndParkingMenu($parkingLot, $parkingMenu)) {
                $errorMessage = trans('message.parking_lot.not_exists');
                Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_NOT_FOUND);
            }

            if (isset($request['contract']) && $request['contract']) {
                $checkContract = $this->validateContract($request['contract']['contractID']);
                if (!$checkContract) {
                    $errorMessage = trans('message.contract.contractID_invalid');
                    Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                    return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_NOT_ACCEPTABLE);
                }

                $checkPrefecture = $this->validatePrefecture($request['contract']['prefectures']);
                if (!$checkPrefecture) {
                    $errorMessage = trans('message.contract.prefecture_invalid');
                    Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                    return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_NOT_ACCEPTABLE);
                }
            }

            DB::beginTransaction();
            if ($request['paymentInfo']['paymentType'] == UseSituation::CREDIT_CARD) {
                $parameters = $this->handlingPayment($request, $params);
                $checkParameters = $this->checkParametersRegisterParking($parameters, $request);

                if (!empty($checkParameters)) {
                    return $checkParameters;
                }

                $parameters = $parameters['param'];
            } else {
                $price = $this->getPriceByBookingType($request);
                $errorMessage = $this->checkCalculationPriceParking($price, $request);

                if (!empty($validateMessage)) {
                    return $errorMessage;
                }

                if ($price['code'] !== config('constants.STATUS_FLAG_TIME.PUBLIC')) {
                    return $this->handleErrorResponseCustomMessage($price['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $arrPaymentRes = [
                    'money_reservation' => $price['price'],
                    'receipt_number' => Carbon::now()->format('Ymd') . 99 . $this->calLastNumberInReceiptNumber()
                ];
                $parameters = array_merge($params, $arrPaymentRes);
            }

            $result = $this->useSituationRepository->store($parameters);

            if ($checkContract && $checkPrefecture && !empty($request['contract'])) {
                $arrayData = $this->getContractData($request, $result);
                $this->contractRepository->store($arrayData);
            }
            DB::commit();

            return response()->json([
                'message' => trans('message.response.success'),
                'data' => fractal()->item($result)
                    ->transformWith(new UseSituationTransformer())
                    ->toArray(),
            ], Response::HTTP_OK);
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api calculate fail == ' . $ex->getMessage());

            return $this->handleResponseServerError();
        }
    }

    public function getContractData($request, $result)
    {
        $useTerms = $this->contractTemplateRepository->show($request['contract']['contractID'])->use_terms;
        $prefectures_cd = $this->prefectureRepository->getByName($request['contract']['prefectures'])->prefectures_cd;

        return [
            'receipt_number' => $result->receipt_number,
            'use_terms' => $useTerms,
            'zip_cd' => $request['contract']['zipCd'],
            'prefectures_cd' => $prefectures_cd,
            'municipality_name' => $request['contract']['municipality'],
            'townname_address' => $request['contract']['townname'],
            'building_name' => $request['contract']['building'],
            'tel_no' => $request['contract']['telPhone'],
            'contractor_name' => $request['contract']['contractorName'],
            'registered_person' => $this->user->name_sei . " " . $this->user->name_mei,
        ];
    }

    public function calLastNumberInReceiptNumber()
    {
        $receiptNumber = $this->useSituationRepository->getLatestReceiptNumber();
        $lastNumberInReceiptNumber = substr($receiptNumber, 10); // Index cutting string , example: 2020010199"1"

        return (intval($lastNumberInReceiptNumber) + 1);
    }

    public function calculatePriceParking(CalculateRequest $request)
    {
        try {
            $price = $this->getPriceByBookingType($request);
            $validateMessage = $this->checkCalculationPriceParking($price, $request);

            if (!empty($validateMessage)) {
                return $validateMessage;
            }

            return response()->json([
                'price' => $price['price']
            ]);
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api calculate fail == ' . $ex->getMessage());

            return $this->handleResponseServerError();
        }
    }

    public function checkEmptyParkingMenu($request)
    {
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request['parkingID']);

        return !empty($parkingMenu);
    }

    public function getPriceByBookingType($request)
    {
        if ($request['bookingTime']['startDate'] < Carbon::now()->toDateString()) {
            return [
                'code' => config('constants.CHECK_DATE_LESS_NOW'),
                'message' => trans('message.check_date_less_now')
            ];
        }

        $price = $this->checkPriceByBookingType($request);

        if (!empty($price['code'])) {
            return $price;
        }

        if ($price == config('constants.PRICE_ZERO')) {
            return [
                'code' => config('constants.CHECK_PRICE_GREATER_ZERO'),
                'message' => trans('message.check_price_greater_zero')
            ];
        }

        return [
            'code' => config('constants.STATUS_FLAG_TIME.PUBLIC'),
            'price' => $price
        ];
    }

    public function checkPriceByBookingType($request)
    {
        $parkingLot = $this->parkingLotRepository->find($request['parkingID']);
        $parkingMenu = $this->parkingMenuRepository->getMenuByParkingCD($request['parkingID']);
        $arrayTimeFlg = $this->useSituation->getTimeFlag($parkingMenu);
        $getSalesTime = $this->useSituation->getSalesTime($parkingLot);

        switch ($request['bookingTime']['bookingType']) {
            case UseSituation::RENT_BY_HOUR:
                if ($arrayTimeFlg['time_flg'] == config('constants.STATUS_FLAG_TIME.PRIVATE')) {
                    return [
                        'code' => config('constants.STATUS_FLAG_TIME.HOUR'),
                        'message' => trans('message.time_flag.rent_by_hour'),
                    ];
                }

                if ($request['bookingTime']['startTime'] < Carbon::now()->toTimeString() && $request['bookingTime']['startDate'] == Carbon::now()->toDateString()) {
                    return [
                        'code' => config('constants.CHECK_HOUR_LESS_NOW'),
                        'message' => trans('message.check_hour_less_now')
                    ];
                }

                $price = $this->parkingMenuTimeRepository->calculateTime(
                    $parkingMenu->menu_cd,
                    $request['bookingTime']['startDate'],
                    $request['bookingTime']['startTime'],
                    $request['bookingTime']['endTime']
                );

                if (
                    $price == config('constants.PRICE_ZERO') ||
                    ($getSalesTime['sales_division'] == 0 &&
                        ($request['bookingTime']['startTime'] < $getSalesTime['sales_start_time'] ||
                            $request['bookingTime']['startTime'] > $getSalesTime['sales_end_time'] ||
                            $request['bookingTime']['endTime'] > $getSalesTime['sales_end_time'] ||
                            $request['bookingTime']['endTime'] < $getSalesTime['sales_start_time'] ||
                            $request['bookingTime']['endTime'] < $request['bookingTime']['startTime']))
                ) {
                    return [
                        'code' => config('constants.CHECK_DATE_FIT'),
                        'message' => trans('message.check_date_fit'),
                    ];
                }

                break;
            case UseSituation::RENT_BY_DAY:
                if ($arrayTimeFlg['day_flg'] == config('constants.STATUS_FLAG_TIME.PRIVATE')) {
                    return [
                        'code' => config('constants.STATUS_FLAG_TIME.DATE'),
                        'message' => trans('message.time_flag.rent_by_day'),
                    ];
                }

                if ($request['bookingTime']['startTime'] < Carbon::now()->toTimeString() && $request['bookingTime']['startDate'] == Carbon::now()->toDateString()) {
                    return [
                        'code' => config('constants.CHECK_HOUR_LESS_NOW'),
                        'message' => trans('message.check_hour_less_now')
                    ];
                }

                $price = intval($parkingMenu->day_price);
                break;
            case UseSituation::RENT_BY_PERIOD:
                if ($arrayTimeFlg['period_flg'] == config('constants.STATUS_FLAG_TIME.PRIVATE')) {
                    return [
                        'code' => config('constants.STATUS_FLAG_TIME.PERIOD'),
                        'message' => trans('message.time_flag.rent_by_period'),
                    ];
                }
                $price = $this->parkingMenuRepository->calculatorPeriod(
                    $parkingMenu,
                    $request['bookingTime']['startDate'],
                    $request['bookingTime']['endDate'],
                    $this->getListHolidays()
                );
                $fromDay = $this->replaceTime($this->parkingMenuRepository->getFromAndToTime($parkingMenu)['from_day']);
                $toDay = $this->replaceTime($this->parkingMenuRepository->getFromAndToTime($parkingMenu)['to_day']);

                if (!$price) {
                    return [
                        'code' => config('constants.STATUS_FLAG_TIME.PERIOD'),
                        'message' => trans('message.period_time_validate', ['from' => $fromDay, 'to' => $toDay]),
                    ];
                }

                if (isset($price['code']) && $price['code'] == config('constants.CHECK_DATE_FIT')) {
                    return [
                        'code' => config('constants.CHECK_WEEKDAY_FIT'),
                        'message' => trans('message.check_weekday_fit')
                    ];
                }
                break;
            case UseSituation::RENT_BY_MONTH:
                if ($arrayTimeFlg['month_flg'] == config('constants.STATUS_FLAG_TIME.PRIVATE')) {
                    return [
                        'code' => config('constants.STATUS_FLAG_TIME.MONTH'),
                        'message' => trans('message.time_flag.rent_by_month'),
                    ];
                }

                if ($parkingMenu->minimum_use > $request['bookingTime']['month']) {
                    return [
                        'code' => config('constants.CHECK_MINIMUM_USE'),
                        'message' => trans('message.check_minimum_month', ['month' => $parkingMenu->minimum_use]),
                    ];
                }

                $price = intval($parkingMenu->month_price) * $request['bookingTime']['month'];
                break;
            default:
                $price = config('constants.PRICE_ZERO');
        }

        return $price;
    }

    public function getListHolidays()
    {
        $listHolidays = $this->holidayRepository->all()->toArray();
        $datas = [];
        foreach ($listHolidays as $holiday) {
            $datas[] = $holiday['date'];
        }

        return $datas;
    }

    public function forwardTokenToNative(Request $request)
    {
        $params = $this->decryptUnivapay($request->paramEncrypt);
        $params['shopId'] = config('payment.sid');

        return view('api::encrypt', compact('params'));
    }

    function decryptUnivapay($paramEncrypt)
    {
        $paramEncrypt = strtr($paramEncrypt, ' ', '+');
        $encrypt_method = config('payment.encrypt_method');
        $secretKey = config('payment.secret_key');
        $secretIV = config('payment.secretIV');
        $output = openssl_decrypt($paramEncrypt, $encrypt_method, $secretKey, 0, $secretIV);
        $output = explode("&", $output);
        $params = [];

        foreach ($output as $key => $value) {
            $value = explode("=", $value);

            if (!isset($value[0]) || !isset($value[1])) {
                $value[1] = '';
            }

            $params[$value[0]] = $value[1];
        }

        return $params;
    }

    public function updateTokenKey($tokenUpdate)
    {
        try {
            if ($tokenUpdate != '') {
                $arrayTokenInfo['token_key'] = $tokenUpdate;
                $this->userRepository->update($this->user->user_cd, $arrayTokenInfo);

                return true;
            }

            return false;
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == update token fail === ' . $ex->getMessage());

            return false;
        }
    }

    public function getLatestToken()
    {
        try {
            $tokenKey = $this->user->token_key;
            $results = [
                'cardNo' => config('payment.cardNo'),
                'expireMonth' => config('payment.expireMonth'),
                'expireYear' => config('payment.expireYear'),
                'firstName' => config('payment.firstName'),
                'lastName' => config('payment.lastName'),
                'phoneNumber' => config('payment.phoneNumber'),
                'securityCode' => config('payment.securityCode'),
                'paymentToken' => $tokenKey,
            ];

            return response()->json([
                'message' => trans('message.response.success'),
                'data' => $results
            ], Response::HTTP_OK);
        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api get late token fail == ' . $ex->getMessage());

            return $this->handleResponseServerError();
        }
    }

    public function useBooking(UseBookingRequest $request)
    {
        try {
            $paramRequest = [
                "receipt_number" => $request['bookingID'],
                "use_day" => $this->replaceTime($request['useDay']),
                "usetime_from" => $request['useFromTime'],
                "usetime_to" => $request['useToTime'],
                "payment" => $request['paymentPrice'],
            ];
            $isBookingChecked = $this->useSituationRepository->show($request['bookingID']);
            if (!$isBookingChecked) {
                $errorMessage = trans('message.use_booking_not_exists');
                Log::error(__FILE__ . ' ' . __LINE__ . ': ' . $errorMessage);

                return $this->handleErrorResponseCustomMessage($errorMessage, Response::HTTP_BAD_REQUEST);
            }

            $this->useSituationRepository->update($request['bookingID'], $paramRequest);

            return response()->json([
                'message' => trans('message.response.success'),
            ], Response::HTTP_OK);
        } catch (QueryException $exception) {
            Log::error(__FILE__ . ' ' . __LINE__ . ': == Call api get late token fail == ' . $exception->getMessage());

            return $this->handleResponseServerError();
        }
    }

    public function getBookingHistory(BookingHistoryRequest $request)
    {
        $pageSize = $request['pageSize'] ?? config('constants.PAGE_DEFAULT');

        $bookingHistories = $this->useSituationRepository->getBookingHistory($pageSize);

        return response()->json([
            "data" => fractal()->collection($bookingHistories, new BookingHistoriesTransformer()),
            'total' => $bookingHistories->total(),
            'totalPage' => $bookingHistories->lastPage()
        ], Response::HTTP_OK);
    }

    public function getLinkDownloadPDFPayment($bookingID)
    {
        $this->useSituationRepository->findOrFail($bookingID);

        return response()->json([
            'link' => route('download_pdf_payment', $bookingID)
        ], Response::HTTP_OK);
    }

    public function downloadPDFPayment($bookingID)
    {
        $useSituation = $this->useSituationRepository->findOrFail($bookingID);

        $pdf = PDF::loadView('api::pdf.pdf_payment', compact('useSituation'));

        return $pdf->setPaper('a4')->download('pdf_payment.pdf');
    }

    public function getLinkDownloadPDFBill($bookingID)
    {
        $useSituation = $this->useSituationRepository->findOrFail($bookingID);

        return response()->json([
            'link' => route('download_pdf_payment_billing', compact('bookingID'))
        ], Response::HTTP_OK);
    }

    public function downloadPDFBill($bookingID)
    {
        $useSituation = $this->useSituationRepository->findOrFail($bookingID);

        $pdf = PDF::loadView('api::pdf.pdf_payment_billing', compact('useSituation'));

        return $pdf->setPaper('a4')->download('pdf_payment_billing.pdf');
    }
}
