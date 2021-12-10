@extends('owner::layouts.master')
@section('title', '駐車場一覧')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/parking.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 w-100 mt-3 mb-3">
            <a href="{{ route('parkinglot.create') }}" class="text-white btn btn-primary float-right mr-5">
                新規駐車場登録
            </a>
        </div>
        @if (session()->has('error'))
            <div class="alert alert-danger w-100">{{ session()->get('error') }}</div>
        @endif
        <div class="col-lg-12 box-table">
            <table class="w-100 table table-bordered border-0 parking-table">
                <thead>
                <tr class="parking-table__tr">
                    <th class="text-center">
                        NO
                    </th>
                    <th class="text-center" width="15%">
                        駐車場名
                    </th>
                    <th class="text-center" width="45%">
                        所在地
                    </th>
                    <th class="text-center">
                        営業時間
                    </th>
                    <th class="text-center" width="10%">
                        駐車台数
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($parkings as $index => $parking)
                    <tr class="parking-table__tr">
                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <a href="{{ route('parkinglot.edit', ['parkinglot' => $parking->parking_cd ]) }}"><u>{{ $parking->parking_name }}</u></a>
                        </td>
                        <td>{{ $parking->prefecture->prefectures_name }}{{ $parking->municipality_name }}{{ $parking->townname_address }}</td>
                        <td class="text-center" width="15%">
                            @if($parking->sales_division == App\Models\ParkingLot::SALES_DIVISION_ENABLE)
                                {{ __('message.slot_parking.business_hours') }}
                            @else
                                {{ $parking->sales_start_time }} ~ {{ $parking->sales_end_time }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $parking->countParkingSpaces() }}
                        </td>
                        <td class="border-0 parking_menu">
                            <a href="{{ route('parkinglot.show', ['parkinglot' => $parking->parking_cd ]) }}"
                               class="btn btn-danger py-0">
                                駐車メニュー
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-block m-auto pt-5 pb-5">
            <a href="{{ route('top.index') }}" class="text-white btn btn-secondary px-5">
                戻る
            </a>
        </div>
    </div>
<div class="modal fade" id="createOrEditParkingSuccess" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                {{ session()->get('editSuccess') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        @if(session()->has('createSuccess') || session()->has('editSuccess'))
        $('#createOrEditParkingSuccess').modal('show');
        @endif
    </script>
@endsection
