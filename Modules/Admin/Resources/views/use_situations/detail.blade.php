@php
use App\Models\UseSituation;
@endphp
@extends('admin::layouts.master')
@section('title', '利用状況詳細')
@section('content')
    <h3 class="title mt-4">利用状況詳細</h3>
    <div class="box-detail border mt-4">
        <div class="box-top row p-3">
            <div class="col-md-2 col-4">
                <label class="d-block">名称</label>
            </div>
            <div class="col-md-10 col-8">
                <label class="d-block">{{$useSituation->parkingLot->parking_name}}</label>
            </div>
            <div class="col-md-2 col-4">
                <label class="d-block">住所 </label>
            </div>
            <div class="col-md-10 col-8">
                <label class="d-block">〒{{ $useSituation->parkingLot->zip_cd }}</label>
                <label class="d-block">{{ $useSituation->parkingLot->prefectures_cd }}
                    /{{ $useSituation->parkingLot->municipality_name }}</label>
                <label class="d-block">{{ $useSituation->parkingLot->building_name }}</label>
            </div>
        </div>
        <hr>
        <div class="box-middle row p-3">
            <div class="col-md-2 col-4">
                <label class="d-block">利用日</label>
            </div>
            <div class="col-md-6 col-8">
                <label class="d-block">{{ $useSituation->use_day }}</label>
            </div>
            <div class="col-md-2 col-4">
                <label class="d-block">予約日</label>
            </div>
            <div class="col-md-2 col-8">
                <label class="d-block">{{ $useSituation->getReservationDate() }}</label>
            </div>

            <div class="col-md-2 col-4">
                <label class="d-block">利用時間</label>
            </div>
            <div class="col-md-6 col-8">
                <label class="d-block">{{ $useSituation->usetime_from }} ～ {{ $useSituation->usetime_to }}</label>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
            </div>

            <div class="col-md-2 col-4">
                <label class="d-block">料金</label>
            </div>
            <div class="col-md-6 col-8">
                <label class="d-block">{{ $english_format_number = number_format($useSituation->parking_fee, 0, '.', ',') }} <label class="mr-2" for="">円</label></label>
            </div>
            <div class="col-md-2 col-4">
                <label class="d-block" for="">
                    支払方法
                </label>
            </div>
            <div class="col-md-2 col-8">
                <label class="d-block" for="">
                {{ UseSituation::TYPE_CHECKOUT[$useSituation->payment_division] }}
                </label>
            </div>

            <div class="col-md-2 col-4">
                <label class="d-block">車番</label>
            </div>
            <div class="col-md-6 col-4">
                <label class="d-block"> {{ $useSituation->car_type_performance }}
                    - {{ $useSituation->car_no_performance }}</label>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
        </div>

        @if($useSituation->reservation_use_kbn === UseSituation::RESERVATION)
            <hr>
            <div class="box-middle row p-3">
                <div class="col-md-2 col-4">
                    <label class="d-block">予約日</label>
                </div>
                <div class="col-md-6 col-8">
                    <label class="d-block">{{ $useSituation->getReservationDate() }}</label>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-2 col-4">
                    <label class="d-block">予約時間</label>
                </div>
                <div class="col-md-6 col-8">
                    <label class="d-block">{{ $useSituation->from_reservation_time }}
                        ~ {{ $useSituation->to_reservation_time }}</label>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-2 col-4">
                    <label class="d-block">料金</label>
                </div>
                <div class="col-md-6 col-8">
                    <label class="d-block"> {{ $english_format_number = number_format($useSituation->money_reservation, 0, '.', ',') }}<label for="">円</label> </label>
                </div>
                <div class="col-md-2 col-4">
                    <label class="d-block">支払方法</label>
                </div>
                <div class="col-md-2 col-6">
                    <label class="d-block">
                        {{ UseSituation::TYPE_CHECKOUT[$useSituation->payment_division_reservation] }}
                    </label>
                </div>
                <div class="col-md-2 col-4">
                    <label class="d-block">車番</label>
                </div>
                <div class="col-md-6 col-8">
                    <label class="d-block">{{ $useSituation->car_type_reservation }}
                        -{{ $useSituation->car_no_reservation }}</label>
                </div>
            </div>
        @endif
    </div>
    <div class="form-group mt-4 text-center">
        <a href="{{ route('use-situations.index') }}" class="text-white btn btn-secondary px-5">戻る</a>
    </div>
@endsection
