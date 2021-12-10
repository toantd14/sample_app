@php
use App\Models\UseSituation;
@endphp
@extends('owner::layouts.master')
@section('title', '実績管理')
@section('content')
@php
$dataSearch = request()->except('_token');
@endphp
<div class="top-page">
    <div class="mt-4">
        <h2 class="ml-3">利用実績</h2>
        <div class="card-warning">
            <div class="card-body">
                @if ($errors->has('year'))
                <p class="mb-0 text-danger parking-form error">{{ $errors->first('year') }}</p>
                @endif
                <form role="form" method="GET" action="{{ route('search.use.situation') }}" id="search-use-situation">
                    <input type="hidden" name="search-use-situation-validate">
                    <div class="form-group row">
                        <label class="col-xl-2 col-4 font-weight-normal pt-2 pl-md-5">利用年月</label>
                        <div class="col-md-4 col-4 col-xl-2">
                            <div class="d-flex">
                                <input type="text" name="year" class="date_picker_only_year form-control pl-2" placeholder="----" autocomplete="off" value="{{ old('year') ?? $dataSearch['year'] ?? '' }}">
                                <span class="input-arrow"></span>
                                <p class="pt-2 ml-1">年</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-4 col-xl-2 d-flex">
                            <input type="text" name="month" class="date_picker_only_month form-control pl-2" placeholder="----" autocomplete="off" value="{{ old('month') ?? $dataSearch['month'] ?? '' }}">
                            <span class="input-arrow"></span>
                            <p class="pt-2 ml-1">月</p>
                        </div>

                        <label class="col-4 col-xl-2 font-weight-normal pt-2 pl-md-5 text-xl-right">利用日</label>
                        <div class="col-xl-4 col-8">
                            <div class="d-flex">
                                <input class="datepicker date-picker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="use_day_from" autocomplete="off" value="{{ old('use_day_from') ?? $dataSearch['use_day_from'] ?? '' }}">
                                <p class="pt-2 ml-2 mr-2">~</p>
                                <input class="datepicker date-picker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="use_day_to" autocomplete="off" value="{{ old('use_day_to') ?? $dataSearch['use_day_to'] ?? '' }}">
                            </div>
                            @if ($errors->has('use_day_to'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('use_day_to') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-2 col-4 font-weight-normal pl-md-5 pt-2">駐車場</label>
                        <div class="col-xl-4 col-8 mb-2">
                            <select class="form-control" name="parking_lot">
                                <option value="">------</option>
                                @foreach(App\Models\ParkingLot::get() as $parkingLot)
                                <option value="{{ $parkingLot->parking_cd }}" @if(isset($dataSearch['parking_lot']) && $dataSearch['parking_lot']==$parkingLot->parking_cd)
                                    selected
                                    @endif
                                    @if(old('parking_lot') == $parkingLot->parking_cd)
                                    selected
                                    @endif>
                                    {{ $parkingLot->parking_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-4 col-xl-2 font-weight-normal pt-2 pl-md-5 text-xl-right">予約日</label>
                        <div class="col-xl-4 col-8">
                            <div class="d-flex">
                                <input value="{{ old('reservation_day_from') ?? $dataSearch['reservation_day_from'] ?? '' }}" class="date-picker datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="reservation_day_from" autocomplete="off">
                                <p class="pt-2 ml-2 mr-2">~</p>
                                <input value="{{ old('reservation_day_to') ?? $dataSearch['reservation_day_to'] ?? '' }}" class="date-picker datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="reservation_day_to" autocomplete="off">
                            </div>
                            @if ($errors->has('reservation_day_to'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('reservation_day_to') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-xl-2 font-weight-normal pl-md-5">利用区分</label>
                        <div class="col-8 col-md-8">
                            <input type="radio" value="" name="visit_no" checked>
                            <label class="mr-3 ml-1">すべて</label>
                            <input type="radio"
                                @if(old('visit_no') === (string)UseSituation::RENT_BY_MONTH)
                                    checked
                                @elseif(isset($dataSearch['visit_no']) && $dataSearch['visit_no'] == (string)UseSituation::RENT_BY_MONTH)
                                    checked
                                @endif value="{{ UseSituation::RENT_BY_MONTH }}" name="visit_no">
                            <label class="mr-3 ml-1">{{ UseSituation::RENTS[UseSituation::RENT_BY_MONTH] }}</label>
                            <input type="radio"
                                @if(old('visit_no') == UseSituation::RENT_BY_PERIOD)
                                    checked
                                @elseif(isset($dataSearch['visit_no']) && $dataSearch['visit_no'] == UseSituation::RENT_BY_PERIOD)
                                    checked
                                @endif
                                value="{{ UseSituation::RENT_BY_PERIOD }}" name="visit_no">
                            <label class="mr-3 ml-1">{{ UseSituation::RENTS[UseSituation::RENT_BY_PERIOD] }}</label>
                            <input type="radio"
                                @if(old('visit_no') == UseSituation::RENT_BY_HOUR)
                                    checked
                                @elseif(isset($dataSearch['visit_no']) && $dataSearch['visit_no'] == UseSituation::RENT_BY_HOUR)
                                    checked
                                @endif
                                value="{{ UseSituation::RENT_BY_HOUR }}" name="visit_no">
                            <label class="mr-3 ml-1">{{ UseSituation::RENTS[UseSituation::RENT_BY_HOUR] }}</label>
                            <input type="radio"
                                @if(old('visit_no') == UseSituation::RENT_BY_DAY)
                                    checked
                                @elseif(isset($dataSearch['visit_no']) && $dataSearch['visit_no'] == UseSituation::RENT_BY_DAY)
                                    checked
                                @endif
                                value="{{ UseSituation::RENT_BY_DAY }}" name="visit_no">
                            <label class="mr-3 ml-1">{{ UseSituation::RENTS[UseSituation::RENT_BY_DAY] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-xl-2 font-weight-normal pl-md-5">請求区分</label>
                        <div class="col-8 col-md-8">
                            <input type="radio" value="" name="reservation_use_kbn" checked><label class="mr-3 ml-1">すべて</label>
                            <input type="radio" @if(old('reservation_use_kbn')===(string)UseSituation::RESERVATION) checked @elseif(isset($dataSearch['reservation_use_kbn']) && $dataSearch['reservation_use_kbn']==(string)UseSituation::RESERVATION) checked @endif value="{{ UseSituation::RESERVATION }}" name="reservation_use_kbn">
                            <label class="mr-3 ml-1">月単位</label>
                            <input type="radio" @if(old('reservation_use_kbn')===(string)UseSituation::USE_KBN) checked @elseif(isset($dataSearch['reservation_use_kbn']) && $dataSearch['reservation_use_kbn']==(string)UseSituation::USE_KBN) checked @endif value="{{ UseSituation::USE_KBN }}" name="reservation_use_kbn">
                            <label class="mr-3 ml-1">度都</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-xl-2 font-weight-normal pl-md-5">支払区分</label>
                        <div class="col-8 col-md-8">
                            <input type="radio" value="" name="payment_division" checked><label class="mr-3 ml-1">すべて</label>
                            <input type="radio"
                                @if(old('payment_division') === (string)UseSituation::CREDIT_CARD)
                                    checked
                                @elseif(isset($dataSearch['payment_division']) && $dataSearch['payment_division'] == (string)UseSituation::CREDIT_CARD)
                                    checked
                                @endif
                                value="{{ UseSituation::CREDIT_CARD }}" name="payment_division">
                            <label class="mr-3 ml-1">{{ UseSituation::TYPE_CHECKOUT[UseSituation::CREDIT_CARD] }}</label>
                            <input type="radio"
                                @if(old('payment_division') == UseSituation::COMBINI)
                                    checked
                                @elseif(isset($dataSearch['payment_division']) && $dataSearch['payment_division'] == UseSituation::COMBINI)
                                    checked
                                @endif
                                value="{{ UseSituation::COMBINI }}" name="payment_division">
                            <label class="mr-3 ml-1">{{ UseSituation::TYPE_CHECKOUT[UseSituation::COMBINI] }}</label>
                            <input type="radio"
                                @if(old('payment_division') == UseSituation::BILL_CORPORATION)
                                    checked
                                @elseif(isset($dataSearch['payment_division']) && $dataSearch['payment_division'] == UseSituation::BILL_CORPORATION)
                                    checked
                                @endif
                                value="{{ UseSituation::BILL_CORPORATION }}" name="payment_division">
                            <label class="mr-3 ml-1">{{ UseSituation::TYPE_CHECKOUT[UseSituation::BILL_CORPORATION] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-2 col-4 font-weight-normal pt-2 pl-md-5">入金日</label>
                        <div class="col-md-8 col-8">
                            <div class="d-flex">
                                <input value="{{ old('payment_day_from') ?? $dataSearch['payment_day_from'] ?? '' }}" class="date-picker datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="payment_day_from" autocomplete="off">
                                <p class="pt-2 ml-2 mr-2">~</p>
                                <input value="{{ old('payment_day_to') ?? $dataSearch['payment_day_to'] ?? '' }}" class="date-picker datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" name="payment_day_to" autocomplete="off">
                            </div>
                            @if ($errors->has('payment_day_to'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('payment_day_to') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-3 offset-sm-2 offset-lg-2"></div>
                        <button class="col-6 col-sm-3 col-lg-3 btn btn btn-secondary mt-2 btn-search-use-situation">
                            検索
                        </button>
                        <div class="offset-3 offset-sm-1 offset-lg-1"></div>
                        <div class="offset-3 offset-sm-1 offset-lg-1"></div>
                        <a href="{{ route('time-used.index') }}" class="col-6 col-sm-3 col-lg-3 btn btn-secondary mt-2">
                            戻る
                        </a>
                        <div class="offset-3 offset-sm-2 offset-lg-2"></div>
                    </div>
                </form>

                <div class="mt-4 d-flex mb-4">
                    <a href="{{ route('export.use.situation', request()->all()) }}" class="ml-auto mr-4 mt-2">CSV出力</a>
                    <a id="prev-page" class="btn btn-primary mr-2">
                        < </a> <a id="next-page" class="btn btn-primary"> >
                    </a>
                </div>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table table-bordered border-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">駐車場</th>
                            <th class="text-center">申込日</th>
                            <th class="text-center">予約日</th>
                            <th class="text-center">車情報</th>
                            <th class="text-center">利用区分</th>
                            <th class="text-center">請求区分</th>
                            <th class="text-center">支払区分</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($useSituations->count())
                            @foreach($useSituations as $index => $useSituation)
                            <tr>
                                <td class="text-center">{{ $index + $useSituations->firstItem() }}</td>
                                <td>{{ $useSituation->parkingLot->parking_name }}</td>
                                <td class="text-center">
                                    {{ formatDateString($useSituation->created_at) }}
                                </td>
                                <td class="text-center">{{ $useSituation->getReservationDate() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('time-used.show', ['time_used' => $useSituation->receipt_number ]) }}">{{ $useSituation->car_no_reservation }}</a>
                                </td>
                                <td class="text-center">
                                    {{ UseSituation::RENTS[$useSituation->visit_no] }}
                                </td>
                                <td class="text-center">
                                    {{ UseSituation::RESERVE_USE[$useSituation->reservation_use_kbn] }}
                                </td>
                                <td class="text-center">
                                    {{ UseSituation::TYPE_CHECKOUT[$useSituation->payment_division] }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        @if(!$useSituations->count() && request()->routeIs('search.use.situation'))
                        <tr>
                            <th colspan="9">
                                <div class="alert alert-danger text-center" role="alert">
                                    {{ __('message.time_use.list_time_use_error') }}
                                </div>
                            </th>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div id="paginate-use-stituation">
                    {{ $useSituations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var mesSearchRequired = "{{ __('message.search_use_situation.required_without_all') }}"
    var useDayValidate = "{{ __('validation.search_use_situation.use_day_validate') }}"
    var reservationDayValidate = "{{ __('validation.search_use_situation.reservation_day_validate') }}"
    var paymentDayValidate = "{{ __('validation.search_use_situation.payment_day_validate') }}"
</script>

<script src="{{ mix('/js/use_situation.js') }}"></script>
@endsection
