@if (session()->has('editErrors'))
<div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
@endif
<!-- month menu -->
<div class="border by-month mt-2 p-2">
    <form id="form-month" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
        <input type="hidden" name="menu_cd">
        <div class="row">
            <div class="col-md-2 col-4">
                <strong>月極め</strong>
            </div>
            <div class="col-md-10  col-8">
                <p>
                    <label class="ml-3 mr-3"> Off </label>
                    <label class="switch month-flg">
                        <input name="month_flg_check" type="checkbox">
                        <span class=" slider round round_month_flg"></span>
                        <input name="month_flg" type="hidden">
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
                        <input name="month_price" type="text" class="form-control d-inline-block w-100">
                        <p class="text-danger err_month_price"></p>
                    </div>
                    <lable class="col-md-2 col-2">
                        円
                    </lable>
                </div>
                <div class="form-group row">
                    <strong class="col-md-2 col-4">
                        最低利用月<b class="text-danger">*</b>
                    </strong>
                    <div class="col-md-4 col-6">
                        <input name="minimum_use" type="text" class="form-control d-inline-block w-100">
                        <p class="text-danger err_minimum_use"></p>
                    </div>
                    <lable class="col-md-2 col-2">
                        ヶ月
                    </lable>
                </div>
                <div class="form-group row m-0">
                    <button class="float-right btn offset-6 btn-secondary submit-month">
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
    <form id="form-day" method="POST" action="{{ route('menus.day.create_or_update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
        <div class="row">
            <div class="col-md-2 col-4">
                <strong>日貸し</strong>
            </div>
            <div class="col-md-10  col-8">
                <p>
                    <label class="ml-3 mr-3"> Off </label>
                    <label class="switch day-flg">
                        <input name="day_flg_check" type="checkbox">
                        <span class=" slider round round_day_flg"></span>
                        <input name="day_flg" type="hidden">
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
                        <input name="day_price" type="text" class="form-control d-inline-block w-100">
                        <p class="text-danger err_day_price"></p>
                    </div>
                    <lable class="col-md-2 col-4">円／日</lable>
                </div>
                <div class="form-group row m-0">
                    <button class="float-right btn offset-6 btn-secondary submit-day">
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
                        <input name="period_flg_check" type="checkbox">
                        <span class="slider round round_period_flg"></span>
                        <input name="period_flg" type="hidden">
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
                            <input name="period_week" type="checkbox">
                            <label class="label-checkbox"></label>
                            曜日条件
                        </label>
                    </div>
                    <div class="col-md-10 col-8 checkbox-day-of-week">
                        <label class="mr-2" for="">
                            <input name="period_week_data[0]" id="period_week_data0" type="checkbox">
                            <label class="label-checkbox"></label>
                            月
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[1]" id="period_week_data1" type="checkbox">
                            <label class="label-checkbox"></label>
                            火
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[2]" id="period_week_data2" type="checkbox">
                            <label class="label-checkbox"></label>
                            水
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[3]" id="period_week_data3" type="checkbox">
                            <label class="label-checkbox"></label>
                            木
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[4]" id="period_week_data4" type="checkbox">
                            <label class="label-checkbox"></label>
                            金
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[5]" id="period_week_data5" type="checkbox">
                            <label class="label-checkbox"></label>
                            土
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[6]" id="period_week_data6" type="checkbox">
                            <label class="label-checkbox"></label>
                            日
                        </label>
                        <label class="mr-2" for="">
                            <input name="period_week_data[7]" id="period_week_data7" type="checkbox">
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
                            <input name="period_timeflg" type="checkbox" value="1">
                            <label class="label-checkbox"></label>
                            時間条件
                        </label>
                    </div>
                    <div class="col-md-10">
                        <div class="d-flex period_time">
                            <div>
                                <input type="text" name="period_fromtime" class="timepicker form-control d-inline-block w-auto" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                            </div>
                            &nbsp;~&nbsp;
                            <div>
                                <input type="text" name="period_totime" class="timepicker form-control d-inline-block w-auto" autocomplete="off" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}">
                            </div>
                        </div>
                        <p class="text-danger err_period_fromtime"></p>
                        <p class="text-danger err_period_totime"></p>
                    </div>
                </div>
                <div class="form-group row period_dayflg">
                    <div class="col-md-2">
                        <label class="mr-2">
                            <input name="period_dayflg" type="checkbox" value="1">
                            <label class="label-checkbox"></label>
                            日付指定
                        </label>
                    </div>
                    <div class="col-md-10 period_day">
                        <div class="d-md-flex">
                            <div>
                                <input type="text" name="period_fromday" class="datepicker form-control d-inline-block w-auto" placeholder="yyyy/mm/dd" autocomplete="off">
                            </div>
                            &nbsp;~&nbsp;
                            <div>
                                <input type="text" name="period_today" class="datepicker form-control d-inline-block w-auto" placeholder="yyyy/mm/dd" autocomplete="off">
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
                        <input type="text" name="period_price" class="form-control d-inline-block w-100">
                        <p class="text-danger err_period_price"></p>
                    </div>
                    <label class="col-md-2" for="">円</label>
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
    <div class="alert alert-success d-none success_time">
        <span></span>
    </div>
    <div class="alert alert-danger d-none errors_time">
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
                    <input name="time_flg_check" type="checkbox">
                    <span class="slider round round_time_flg"></span>
                    <input name="time_flg" type="hidden">
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
                <input id="menu_cd" name="menu_cd" type="hidden" class="set-menu-cd">
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
                        <input type="hidden" name="number-time-lending" value="1">
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
