@extends('owner::layouts.master')
@section('title', '駐車場メニュー設定')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ mix('/css/update_menu_parking.css') }}">
<link rel="stylesheet" href="{{ mix('/css/parkingtimepicker.css') }}">
@endsection
@section('content')
<div class="create-menu-page mt-4">
    <div class="row">
        <div class="col-md-2 col-3">
            <span class="ml-3" for="">名称</span>
        </div>
        <div class="col-md-10 col-9">
            <p>{{ $parking->parking_name }}</p>
        </div>
    </div>
    <div class="address-box p-3 mb-3">
        <div class="row">
            <div class="col-md-2 col-3">
                <span for="">住所</span>
            </div>
            <div class="col-md-10 col-9 pl-0">
                <p>{{ $parking->zip_cd }}</p>
                <p>{{ $parking->prefecture->prefectures_name. $parking->municipality_name . $parking->townname_address }}</p>
                <p class="pb-0">{{ $parking->building_name }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-3">
            <span class="ml-3" for="">電話番号</span>
        </div>
        <div class="col-md-10 col-9">
            <p>{{ $parking->tel_no }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-3">
            <span class="ml-3" for="">FAX番号</span>
        </div>
        <div class="col-md-10 col-9">
            <p>{{ $parking->fax_no }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-3"><span class="ml-3" for="">営業時間</span></div>
        <div class="col-md-10 col-9">
            @if($parking->sales_division == App\Models\ParkingLot::SALES_DIVISION_ENABLE)
            {{ __('message.slot_parking.business_hours') }}
            @else
            {{ $parking->sales_start_time }} ～ {{ $parking->sales_end_time }}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-4 text-right"><span class="" for="">入庫</span></div>
        <div class="col-md-9 col-8">
            @if($parking->lu_division == App\Models\ParkingLot::LU_DIVISION_ENABLE)
            {{ __('message.slot_parking.business_hours') }}
            @else
            {{ $parking->lu_start_time }}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-4 text-right"><span class="" for="">出庫</span></div>
        <div class="col-md-9 col-8">
            @if($parking->lu_division == App\Models\ParkingLot::LU_DIVISION_DISABLE)
            {{ $parking->lu_end_time }}
            @endif
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active px-5" data-toggle="tab" href="#image">画像</a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-5" data-toggle="tab" href="#video">動画</a>
        </li>
    </ul>
    <div class="tab-content border-top-0 border pb-2">
        <div id="image" class="container tab-pane active"><br>
            <div class="row">
                <div class="col-6 col-md-3 text-center p-xs-1">
                    @if(!$parking->image1_url)
                    <div class="d-flex file-1 h-100 p-1 border image-item">
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する画像がありません</label>
                        </div>
                    </div>
                    @else
                    <div id="filePreviewEdit1" class="p-2 file-preview-area1 file-preview-area">
                        <img class="img-upload-preview1 img-upload-preview" src="{{ $parking->image1_url ? asset('storage/'.$parking->image1_url) : '' }}" alt="preview uploaded file">
                        <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                    </div>
                    @endif
                </div>
                <div class="col-6 col-md-3 text-center p-xs-1">
                    @if(!$parking->image2_url)
                    <div class="d-flex file-1 h-100 p-1 border image-item">
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する画像がありません</label>
                        </div>
                    </div>
                    @else
                    <div id="filePreviewEdit1" class="p-2 file-preview-area1 file-preview-area">
                        <img class="img-upload-preview1 img-upload-preview" src="{{ $parking->image2_url ? asset('storage/'.$parking->image2_url) : '' }}" alt="preview uploaded file">
                        <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                    </div>
                    @endif
                </div>
                <div class="col-6 col-md-3 text-center p-xs-1">
                    @if(!$parking->image3_url)
                    <div class="d-flex file-1 h-100 p-1 border image-item">
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する画像がありません</label>
                        </div>
                    </div>
                    @else
                    <div id="filePreviewEdit1" class="p-2 file-preview-area1 file-preview-area">
                        <img class="img-upload-preview1 img-upload-preview" src="{{ $parking->image3_url ? asset('storage/'.$parking->image3_url) : '' }}" alt="preview uploaded file">
                        <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                    </div>
                    @endif
                </div>
                <div class="col-6 col-md-3 text-center p-xs-1">
                    @if(!$parking->image4_url)
                    <div class="d-flex file-1 h-100 p-1 border image-item">
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する画像がありません</label>
                        </div>
                    </div>
                    @else
                    <div id="filePreviewEdit1" class="p-2 file-preview-area1 file-preview-area">
                        <img class="img-upload-preview1 img-upload-preview" src="{{ $parking->image4_url ? asset('storage/'.$parking->image4_url) : '' }}" alt="preview uploaded file">
                        <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="video" class="container tab-pane fade"><br>
            <div class="box">
                <div class="row">
                    <div class="col-6 col-md-3 text-center p-xs-1">
                        @if(!$parking->video1_url)
                        <div class="d-flex file-1 h-100 p-1 border image-item">
                            <div class="d-flex justify-content-center align-items-center w-100">
                                <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する動画はありません</label>
                            </div>
                        </div>
                        @else
                        <div id="videoPreview1" class="p-2 file-preview-area1 file-preview-area">
                            <video controls class="video-upload-preview1 video-upload-preview">
                                <source src="{{ $parking->video1_url ? asset('storage/'.$parking->video1_url) : '' }}">
                            </video>
                            <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                        </div>
                        @endif
                    </div>
                    <div class="col-6 col-md-3 text-center p-xs-1">
                        @if(!$parking->video2_url)
                        <div class="d-flex file-1 h-100 p-1 border image-item">
                            <div class="d-flex justify-content-center align-items-center w-100">
                                <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する動画はありません</label>
                            </div>
                        </div>
                        @else
                        <div id="videoPreview2" class="p-2 file-preview-area1 file-preview-area">
                            <video controls class="video-upload-preview2 video-upload-preview">
                                <source src="{{ $parking->video2_url ? asset('storage/'.$parking->video2_url) : '' }}">
                            </video>
                            <div class="img-upload-name-preview2 img-upload-name-preview"></div>
                        </div>
                        @endif
                    </div>
                    <div class="col-6 col-md-3 text-center p-xs-1">
                        @if(!$parking->video3_url)
                        <div class="d-flex file-1 h-100 p-1 border image-item">
                            <div class="d-flex justify-content-center align-items-center w-100">
                                <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する動画はありません</label>
                            </div>
                        </div>
                        @else
                        <div id="videoPreview3" class="p-2 file-preview-area1 file-preview-area">
                            <video controls class="video-upload-preview3 video-upload-preview">
                                <source src="{{ $parking->video3_url ? asset('storage/'.$parking->video3_url) : '' }}">
                            </video>
                            <div class="img-upload-name-preview3 img-upload-name-preview"></div>
                        </div>
                        @endif
                    </div>
                    <div class="col-6 col-md-3 text-center p-xs-1">
                        @if(!$parking->video4_url)
                        <div class="d-flex file-1 h-100 p-1 border image-item">
                            <div class="d-flex justify-content-center align-items-center w-100">
                                <label for="btnInputUpload1" class="file-label-images1 file-label-images">表示する動画はありません</label>
                            </div>
                        </div>
                        @else
                        <div id="videoPreview4" class="p-2 file-preview-area1 file-preview-area">
                            <video controls class="video-upload-preview4 video-upload-preview">
                                <source src="{{ $parking->video4_url ? asset('storage/'.$parking->video4_url) : '' }}">
                            </video>
                            <div class="img-upload-name-preview4 img-upload-name-preview"></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('owner::menus.menu_modal_sucess')
    @include('owner::menus.menu_modal_error')
    @if($parking['parkingMenu'])
    @if (session()->has('editErrors'))
    <div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
    @endif
    <!-- month menu -->
    <div class="border by-month mt-2 p-2">
        <form method="POST" action="" id="form-month" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
            <input type="hidden" name="menu_cd" value="{{ $parking->parkingMenu->menu_cd }}">
            <div class="row">
                <div class="col-md-2 col-4">
                    <strong>月極め</strong>
                </div>
                <div class="col-md-10 col-8">
                    <p>
                        <label class="ml-3 mr-3"> Off </label>
                        <label class="switch month-flg">
                            <input name="month_flg_check" type="checkbox" {{ $parking->parkingMenu->month_flg == App\Models\ParkingMenu::MONTH_FLG_ENABLE ? 'checked' : '' }} value="{{ $parking->parkingMenu->month_flg == App\Models\ParkingMenu::MONTH_FLG_ENABLE ? '0' : '1' }}">
                            <span class="slider round round_month_flg"></span>
                            <input name="month_flg" type="hidden" value="{{ $parking->parkingMenu->month_flg == App\Models\ParkingMenu::MONTH_FLG_ENABLE ? '0' : '1' }}">
                        </label>
                        <label class="ml-3"> On </label>
                    </p>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-10 input-check-month">
                    <div class="form-group row">
                        <strong class="col-md-2 col-4">
                            月額駐車料<b class="text-danger">*</b>
                        </strong>
                        <div class="col-md-4 col-6">
                            <input name="month_price" type="text" class="form-control d-inline-block w-100" value="{{ old('month_price') ?? $parking->parkingMenu->month_price }}">
                            <p class="text-danger err_month_price"></p>
                        </div>
                        <lable class="col-md-2 col-2">円／月</lable>
                    </div>
                    <div class="form-group row">
                        <strong class="col-md-2 col-4">
                            最低利用月<b class="text-danger">*</b>
                        </strong>
                        <div class="col-md-4 col-6">
                            <input name="minimum_use" type="text" class="form-control d-inline-block w-100" value="{{ old('minimum_use') ?? $parking->parkingMenu->minimum_use }}">
                            <p class="text-danger err_minimum_use"></p>
                        </div>
                        <lable class="col-md-2 col-2">
                            ヶ月
                        </lable>
                    </div>
                    <div class="form-group row m-0">
                        <button type="submit" form="form-month" class="float-right btn offset-6 btn-secondary submit-month">
                            登録/更新
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end month menu -->
    <!-- day menu -->
    <div class="border by-day mt-2 p-2">
        <form method="POST" action="" id="form-day" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
            <div class="row">
                <div class="col-md-2 col-4">
                    <strong>日貸し</strong>
                </div>
                <div class="col-md-10 col-8">
                    <p>
                        <label class="ml-3 mr-3"> Off </label>
                        <label class="switch day-flg">
                            <input name="day_flg_check" type="checkbox" {{ $parking->parkingMenu->day_flg == App\Models\ParkingMenu::DAY_FLG_ENABLE ? 'checked' : '' }} value="{{ $parking->parkingMenu->day_flg == App\Models\ParkingMenu::DAY_FLG_ENABLE ? '0' : '1' }}">
                            <span class="slider round round_day_flg"></span>
                            <input name="day_flg" type="hidden" value="{{ $parking->parkingMenu->day_flg == App\Models\ParkingMenu::DAY_FLG_ENABLE ? '0' : '1' }}">
                        </label>
                        <label class="ml-3"> On </label>
                    </p>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-10 input-check-day">
                    <div class="form-group row">
                        <strong class="col-md-2 col-4">
                            日額駐車料<b class="text-danger">*</b>
                        </strong>
                        <div class="col-md-4 col-6">
                            <input name="day_price" type="text" class="form-control d-inline-block w-100" value="{{ old('day_price') ?? $parking->parkingMenu->day_price }}">
                            <p class="text-danger err_day_price"></p>
                        </div>
                        <lable class="col-md-2 col-4">円／日</lable>
                    </div>
                    <div class="form-group row m-0">
                        <button type="submit" form="form-day" class="float-right btn offset-6 btn-secondary submit-day">
                            登録/更新
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end day menu -->
    <!-- period menu -->
    <div class="border by-day mt-2 p-2">
        <form id="form-period" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
            <div class="alert alert-danger d-none errors_period">
                <span></span>
            </div>
            <div class="row">
                <div class="col-md-2 col-4">
                    <strong>期間(定期)貸し</strong>
                </div>
                <div class="col-md-10  col-8">
                    <p>
                        <label class="ml-3 mr-3"> Off </label>
                        <label class="switch">
                            <input name="period_flg_check" type="checkbox" {{ $parking->parkingMenu->period_flg == App\Models\ParkingMenu::PERIOD_FLG_ENABLE ? 'checked' : '' }} value="{{ $parking->parkingMenu->period_flg == App\Models\ParkingMenu::PERIOD_FLG_ENABLE ? '0' : '1' }}">
                            <span class="slider round round_period_flg"></span>
                            <input name="period_flg" type="hidden" value="{{ $parking->parkingMenu->period_flg == App\Models\ParkingMenu::PERIOD_FLG_ENABLE ? '0' : '1' }}">
                        </label>
                        <label class="ml-3"> On </label>
                    </p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-10"><input type="hidden" name="period_week_or_time"></div>
                <div class="col-md-2">
                </div>
                <div class="col-md-10 input-check-period">
                    <div class="form-group row period_week">
                        <div class="col-md-2 col-4 period_week_switch">
                            <label class="mr-2" for="">
                                <input name="period_week" type="checkbox" {{ $parking->parkingMenu->period_week == App\Models\ParkingMenu::PERIOD_WEEK_FLG_ENABLE ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                曜日条件
                            </label>
                        </div>
                        <div class="col-md-10 col-8 checkbox-day-of-week {{ $parking->parkingMenu->period_week == App\Models\ParkingMenu::PERIOD_WEEK_FLG_DISABLE ? 'disable-div' : '' }}">
                            <label class="mr-2" for="">
                                <input name="period_week_data[0]" type="checkbox" id="period_week_data0" {{ $parking->parkingMenu->period_monday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                月
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[1]" type="checkbox" id="period_week_data1" {{ $parking->parkingMenu->period_tuesday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                火
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[2]" type="checkbox" id="period_week_data2" {{ $parking->parkingMenu->period_wednesday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                水
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[3]" type="checkbox" id="period_week_data3" {{ $parking->parkingMenu->period_thursday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                木
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[4]" type="checkbox" id="period_week_data4" {{ $parking->parkingMenu->period_friday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                金
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[5]" type="checkbox" id="period_week_data5" {{ $parking->parkingMenu->period_saturday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                土
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[6]" type="checkbox" id="period_week_data6" {{ $parking->parkingMenu->period_sunday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                日
                            </label>
                            <label class="mr-2" for="">
                                <input name="period_week_data[7]" type="checkbox" id="period_week_data7" {{ $parking->parkingMenu->period_holiday == App\Models\ParkingMenu::PARKING_MENU_ON ? 'checked' : '' }}>
                                <label class="label-checkbox"></label>
                                祝
                            </label>
                            <input type="hidden" name="period_week_data_validate">
                            <p class="text-danger err_period_week_data"></p>
                            <p class="text-danger err_period_week"></p>
                        </div>
                    </div>
                    <div class="form-group row period_timeflg disable-div">
                        <div class="col-md-2">
                            <label class="mr-2" for="">
                                <input name="period_timeflg" type="checkbox" {{ $parking->parkingMenu->period_timeflg == App\Models\ParkingMenu::PERIOD_TIME_FLG_ENABLE ? 'checked' : ''}}>
                                <label class="label-checkbox"></label>
                                時間条件
                            </label>
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex period_time">
                                <div>
                                    <input type="text" name="period_fromtime" class="timepicker form-control d-inline-block w-auto" value="{{ old('period_fromtime') ?? $parking->parkingMenu->period_fromtime }}" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                                </div>
                                &nbsp;~&nbsp;
                                <div>
                                    <input type="text" name="period_totime" class="timepicker form-control d-inline-block w-auto" value="{{ old('period_totime') ?? $parking->parkingMenu->period_totime }}" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                                </div>
                            </div>
                            <p class="text-danger err_period_fromtime"></p>
                            <p class="text-danger err_period_totime"></p>
                        </div>
                    </div>
                    <div class="form-group row period_dayflg">
                        <div class="col-md-2">
                            <label class="mr-2">
                                <input name="period_dayflg" type="checkbox" {{ $parking->parkingMenu->period_dayflg == App\Models\ParkingMenu::PERIOD_DAY_FLG_ENABLE ? 'checked' : ''}}>
                                <label class="label-checkbox"></label>
                                日付指定
                            </label>
                        </div>
                        <div class="col-md-10 period_day {{ $parking->parkingMenu->period_dayflg == App\Models\ParkingMenu::PERIOD_DAY_FLG_DISABLE ? 'disable-div' : '' }}">
                            <div class="d-md-flex">
                                <div>
                                    <input type="text" name="period_fromday" class="datepicker form-control d-inline-block w-auto" placeholder="yyyy/mm/dd" value="{{ old('period_fromday') ?? $parking->parkingMenu->period_fromday }}" autocomplete="off">
                                </div>
                                &nbsp;~&nbsp;
                                <div>
                                    <input type="text" name="period_today" class="datepicker form-control d-inline-block w-auto" placeholder="yyyy/mm/dd" value="{{ old('period_today') ?? $parking->parkingMenu->period_today }}" autocomplete="off">
                                </div>
                            </div>
                            <p class="text-danger err_period_fromday"></p>
                            <p class="text-danger err_period_today"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="">駐車料<b class="text-danger">*</b></label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="period_price" class="form-control d-inline-block w-100" value="{{ old('period_price') ?? $parking->parkingMenu->period_price }}">
                            <p class="text-danger err_period_price"></p>
                        </div>
                        <lable class="col-md-2 col-4">円／日</lable>
                    </div>
                    <p class="text-primary">※「曜日指定＋時間条件」とするか、日付での期間指定とするか、いずれかを指定します。</p>
                    <div class="form-group row m-0">
                        <button class="float-right btn offset-md-5 offset-6 btn-secondary submit-period">
                            登録/更新
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end period menu -->
    <div class="by-hour border mt-2 p-2">
        <div class="alert alert-danger d-none error_time">
            <span></span>
        </div>
        <div class="alert alert-success d-none success_time">
            <span></span>
        </div>
        <input type="hidden" class="set-data-id">
        <div class="row">
            <div class="col-md-2 col-4">
                <strong>時間貸し</strong>
            </div>
            <div class="col-md-10  col-8">
                <p>
                    <label class="ml-3 mr-3"> Off </label>
                    <label class="switch">
                        <input name="time_flg_check" type="checkbox" {{ $parking->parkingMenu->time_flg == App\Models\ParkingMenu::TIME_FLG_ENABLE ? 'checked' : '' }} value="{{ $parking->parkingMenu->time_flg == App\Models\ParkingMenu::TIME_FLG_ENABLE ? '0' : '1' }}">
                        <span class="slider round round_time_flg"></span>
                        <input name="time_flg" type="hidden" value="{{ $parking->parkingMenu->time_flg == App\Models\ParkingMenu::TIME_FLG_ENABLE ? '0' : '1' }}">
                    </label>
                    <label class="ml-3"> On </label>
                </p>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-10 input-check-time">
                <form method="POST" class="form-lending-time" id="form-add-menu-time" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="">日種別 <b class="text-danger">*</b> </label>
                        </div>
                        <div class="col-md-10 ">
                            <label class="mr-2" for=""><input class="day_type" value="{{ App\Models\ParkingMenuTime::WEEKDAYS }}" name="day_type" type="radio" checked>
                                平日</label>
                            <label class="mr-2" for=""><input class="day_type" value="{{ App\Models\ParkingMenuTime::SATURDAY }}" name="day_type" type="radio">
                                土曜日</label>
                            <label class="mr-2" for=""><input class=day_type value="{{ App\Models\ParkingMenuTime::SUNDAY }}" name="day_type" type="radio"> 日曜日</label>
                            <label class="mr-2" for=""><input class="day_type" value="{{ App\Models\ParkingMenuTime::HOLIDAYS }}" name="day_type" type="radio">
                                祝祭日</label>
                            <p class="text-danger day_type_error mb-2 mt-2"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label class="mr-2" for="">駐車時間帯 <b class="text-danger">*</b></label>
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex">
                                <div class="" style="width: 22%">
                                    <input name="from_time" class="timepicker form-control d-inline-block"
                                            type="text" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                                    <p class="text-danger from_time_error mb-2 mt-2"></p>
                                </div>
                                &nbsp;~&nbsp;
                                <div class="mr-2" style="width: 22%">
                                    <input name="to_time" class="timepicker form-control d-inline-block" type="text" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                                    <p class="text-danger to_time_error mb-2 mt-2"></p>
                                </div>
                                <div class="" style="width: 22%">
                                    <input name="price" class="form-control d-inline-block" placeholder="{{ config('constants.MENU_TIME.PRICE_PLACEHOLDER_FORMAT') }}">
                                    <p class="text-danger price_error mb-2 mt-2"></p>
                                </div>
                                <label class="mt-2 mr-3 ml-3">円</label>
                                <div style="width: 22%">
                                    <button type="submit" class="float-right btn btn-secondary submit-time">
                                        登録/更新
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="POST" class="form-data-lending" id="form-data-menu-time" action="{{ route('menus.time.create_or_update') }}">
                    @csrf
                    <input name="parking_cd" type="hidden" class="set-parking-cd" value="{{ $parking->parking_cd }}">
                    <input name="menu_cd" type="hidden" class="set-menu-cd" value="{{ $parking->parkingMenu->menu_cd }}">
                    <input name="menu_time_no" type="hidden" class="set-menu-time-no">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label class="mr-2" for=""> 【平日】</label>
                        </div>
                        <div class="col-md-10">
                        </div>
                    </div>
                    <div id="table">
                        <table class="table table-bordered border-0 text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">日種別</th>
                                    <th scope="col">時間帯</th>
                                    <th scope="col">料金</th>
                                    <th scope="col" class="border-0 w-25"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach($parkingMenuTime as $key => $time)
                                <tr class="tr{{$no}}">
                                    <th class="th-no">
                                        {{ $no }}
                                        <input hidden name="data[{{$no}}][id]" value="{{ $time->id ?? '' }}">
                                    </th>
                                    <th class="th-day-type">
                                        <input hidden name="data[{{$no}}][day_type]" value="{{ $time->day_type }}">
                                        @if ($time->day_type == App\Models\ParkingMenuTime::WEEKDAYS)
                                        <span>平日</span>
                                        @elseif ($time->day_type == App\Models\ParkingMenuTime::SATURDAY)
                                        <span>土曜日</span>
                                        @elseif($time->day_type == App\Models\ParkingMenuTime::SUNDAY)
                                        <span>日曜日</span>
                                        @else
                                        <span>祝祭日</span>
                                        @endif
                                    </th>
                                    <th class="th-from-to-time">
                                        <input hidden name="data[{{$no}}][from_time]" value="{{ $time->from_time }}">
                                        <input hidden name="data[{{$no}}][to_time]" value="{{ $time->to_time }}">
                                        <span>{{ $time->from_time }} ～　{{ $time->to_time != '00:00' ? $time->to_time : '24:00' }}</span>
                                    </th>
                                    <td class="td-price">
                                        <input hidden name="data[{{$no}}][price]" value="{{ $time->price }}">
                                        <span>{{ $time->price }}</span>
                                    </td>
                                    <td class="border-0 text-left">
                                        <span data-no="{{ $no }}" data-from_time="{{ $time->from_time }}" data-to_time="{{ $time->to_time }}" data-price="{{ $time->price }}" data-day_type="{{ $time->day_type }}" class="btn btn-primary btn-edit-time">
                                            編集
                                        </span>
                                        <span data-no="{{ $no }}" data-time-id="{{ $time->id }}" class="btn btn-danger btn-delete-time">削除</span>
                                    </td>
                                </tr>
                                @php $no += 1 @endphp
                                @endforeach
                                <input type="hidden" name="number-time-lending" value="{{ $no }}">
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row">
                        <button type="button" class="float-right btn offset-6 btn-secondary submit-lending m-auto">
                            登録/更新
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <a href="{{ route('parkinglot.index') }}" class="col-md-2 btn btn-secondary text-center mx-2 mt-4">駐車場登録へ</a>
        <a href="{{ route('top.index') }}" class="col-md-2 btn btn-secondary text-center mx-2 mt-4">戻る</a>
    </div>
    @else
    @include('owner::parking.form_create_menu')
    @endif
</div>

{{-- modal delete time--}}
<div class="modal fade" id="modalDeleteTime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <input type="hidden" class="input-modal-delete-time" name="modal-delete-time">
    <input type="hidden" class="menu-time-id">
    <form method="POST" action="" class="form-confirm-delete-time">
        <input type="hidden" name="_method" value="DELETE">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('message.menu.time.message_confirm_delete') }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-delete-time">Ok</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('message.menu.time.cancel') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    var urlCreateOrUpdateDay = "{{ route('menus.day.create_or_update') }}";
    var urlCreateOrUpdateMonth = "{{ route('menus.month.create_or_update') }}";
    var urlCreateOrUpdatePeriod = "{{ route('menus.period.create_or_update') }}";
    var urlUpdateFlg = '{{ route("menus.update_menu_flg") }}';
    var messageSuccess = '{{ __("message.success") }}';
    var messageError = '{{ __("message.error") }}';
    var dateDefault = '{{ config("constants.DATE_DEFAULT") }}';
    var validateRequired = '{{ __("validation.parkinglot.required") }}';
    var validatePeriodTime = '{{ __("validation.period_time_from_to") }}';
    var validatePeriodDay = '{{ __("validation.period_day_from_to") }}';
    var validateMenuTime = '{{ __("validation.menutime_from_to") }}';
    var validatePositionInteger = '{{ __("validation.positive_integer") }}';
    var validateInteger = '{{__("validation.number_integer")}}';
    var urlCreateOrUpdateMenuTime = '{{ route("menus.time.create_or_update") }}';
    var dayTypeContent = {
        0: '{{ config("constants.DAY_TYPE_PARKING_TIME.0") }}',
        1: '{{ config("constants.DAY_TYPE_PARKING_TIME.1") }}',
        2: '{{ config("constants.DAY_TYPE_PARKING_TIME.2") }}',
        3: '{{ config("constants.DAY_TYPE_PARKING_TIME.3") }}'
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var messageRequired = '{{ __("message.message_required") }}';
    var messageSelectRequired = "{{ __('message.member.message_select_required') }}";
    var messageNumberPrice = "{{ __('message.message_number_price') }}";
    var validatePeriodWeekOrTime = "{{ __('validation.period_week_or_time') }}";
</script>
<script src="{{ mix('/js/common/common-parking-menu.js') }}"></script>
<script src="{{ mix('/js/common/common-validate-menu.js') }}"></script>
<script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
<script src="{{ mix('/js/ajax_form_menu.js') }}"></script>
<script src="{{ mix('/js/common/common-parking-time-picker.js') }}"></script>
@endsection
