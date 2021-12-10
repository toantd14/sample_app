@extends('admin::layouts.master')
@section('title', '駐車場管理')
@section('css')
<link rel="stylesheet" href="{{ asset('/css/parking.css') }}">
@endsection
@section('content')
@php
    $dataSearch = request()->except('_token');
@endphp
<div class="row">
    <div class="col-lg-12 w-100 mt-3 mb-3">
        <h2 class="float-left mt-1">駐車場管理</h2>
        <a href="{{ route('parkings.create') }}" class="text-white btn btn-primary float-right mr-5">
            新規駐車場登録
        </a>
    </div>
    <div class="col-lg-12 w-100 mt-3 mb-3">
        <form role="form" method="GET" action="{{ route('search.parking') }}">
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2">所在地</label>
                <div class="col-md-3 col-xl-3">
                    <select class="form-control" name="prefectures_cd">
                        <option value="">（都道府県）</option>
                        @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefectures_cd }}"
                            @if(isset($dataSearch['prefectures_cd']) && $dataSearch['prefectures_cd'] == $prefecture->prefectures_cd)
                                selected
                            @endif
                            @if(old('prefectures_cd') == $prefecture->prefectures_cd)
                                selected
                            @endif>
                            {{ $prefecture->prefectures_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-xl-3">
                    <input type="text" name="municipality_name" value="{{ old('municipality_name') ?? $dataSearch['municipality_name'] ?? '' }}" class="form-control pl-2" autocomplete="off" placeholder="（市区町村郡）">
                    @if ($errors->has('municipality_name'))
                    <p class="mb-0 text-danger error">{{ $errors->first('municipality_name') }}</p>
                    @endif
                </div>
                <div class="col-md-4 col-xl-4">
                    <label for="" class="pt-2">（２文字以上指定）</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2">駐車場</label>
                <div class="col-md-4 col-xl-4">
                    <select class="form-control" name="parking_cd">
                    <option value="">すべて</option>
                    @foreach($allParking as $parking)
                        <option value="{{ $parking->parking_cd }}"
                            @if(isset($dataSearch['parking_cd']) && $dataSearch['parking_cd'] == $parking->parking_cd)
                                selected
                            @endif
                            @if(old('parking_cd') == $parking->parking_cd)
                                selected
                            @endif>
                            {{ $parking->parking_name }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2">オーナー</label>
                <div class="col-md-4 col-xl-4">
                    <select name="owner_cd" class="form-control">
                        <option value="">すべて</option>
                        @foreach($allOwner as $owner)
                            <option value="{{ $owner->owner_cd }}"
                                @if(isset($dataSearch['owner_cd']) && $dataSearch['owner_cd'] == $owner->owner_cd)
                                    selected
                                @endif
                                @if(old('owner_cd') == $owner->owner_cd)
                                    selected
                                @endif>
                                {{ $owner->name_c }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2">登録日</label>
                <div class="col-md-2 col-xl-2">
                    <input type="text" name="created_at_from" value="{{ old('created_at_from') ?? $dataSearch['created_at_from'] ?? '' }}" class="datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off">
                    @if ($errors->any() && $errors->has('created_at_from'))
                    <p class="mb-0 text-danger error">{{ $errors->first('created_at_from') }}</p>
                    @endif
                </div>
                ~
                <div class="col-md-2 col-xl-2">
                    <input type="text" name="created_at_to" value="{{ old('created_at_to') ?? $dataSearch['created_at_to'] ?? '' }}" class="datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off">
                    @if ($errors->any() && $errors->has('created_at_to'))
                    <p class="mb-0 text-danger error">{{ $errors->first('created_at_to') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2">更新日</label>
                <div class="col-md-2 col-xl-2">
                    <input type="text" name="updated_at_from" value="{{ old('updated_at_from') ?? $dataSearch['updated_at_from'] ?? '' }}" class="datepicker date_picker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off">
                    @if ($errors->any() && $errors->has('updated_at_from'))
                    <p class="mb-0 text-danger error">{{ $errors->first('updated_at_from') }}</p>
                    @endif
                </div>
                ~
                <div class="col-md-2 col-xl-2">
                    <input type="text" name="updated_at_to" value="{{ old('updated_at_to') ?? $dataSearch['updated_at_to'] ?? '' }}" class="datepicker form-control pl-2" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off">
                    @if ($errors->any() && $errors->has('updated_at_to'))
                    <p class="mb-0 text-danger error">{{ $errors->first('updated_at_to') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-2 font-weight-normal pt-2"></label>
                <div class="col-xl-10 col-md-10 d-flex">
                    <button class="col-md-3 col-xl-3 btn btn-secondary">
                        検索
                    </button>
                    <div class="col-md-1 col-xl-1"></div>
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary col-md-3 col-xl-3">戻る</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-2 d-flex">
        <span class="pt-2">
            {{ $parkings->total() }}件
        </span>
    </div>
    <div class="col-lg-10 w-100 d-flex justify-content-end mb-2" style="padding-right: 65px">
        <a id="prev-page" class="btn btn-primary mr-2"> < </a>
        <a id="next-page" class="btn btn-primary"> > </a>
    </div>
    @if (session()->has('error'))
    <div class="alert alert-danger w-100">{{ session()->get('error') }}</div>
    @endif
    <div class="col-lg-12 box-table">
        <table class="w-100 table table-bordered border-0 parking-table">
            <thead>
                <tr class="parking-table__tr">
                    <th class="text-center" width="4%">
                        NO
                    </th>
                    <th class="text-center" width="15%">
                        オーナー
                    </th>
                    <th class="text-center" width="15%">
                        駐車場名
                    </th>
                    <th class="text-center" width="36%">
                        所在地
                    </th>
                    <th class="text-center" width="10%">
                        営業時間
                    </th>
                    <th class="text-center" width="10%">
                        駐車台数
                    </th>
                </tr>
            </thead>
            <tbody>
            @if ($parkings->count())
                @foreach($parkings as $index => $parking)
                <tr class="parking-table__tr">
                    <td class="text-center">
                        {{ $index + $parkings->firstItem() }}
                    </td>
                    <td>
                        {{ $parking->owner->name_c }}
                    </td>
                    <td>
                        <a href="{{ route('parkings.edit', ['parking' => $parking->parking_cd ]) }}"><u>{{ $parking->parking_name }}</u></a>
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
                    <td class="text-center border-0 parking_menu">
                        <a href="{{ route('parkings.show', ['parking' => $parking->parking_cd ]) }}" class="btn btn-danger py-0">
                            駐車メニュー
                        </a>
                    </td>
                </tr>
                @endforeach
            @endif
            @if(!$parkings->count() && request()->routeIs('search.parking'))
                <tr>
                    <th colspan="6">
                        <div class="alert alert-danger text-center" role="alert">
                            {{ __('message.parking_lot.search_results_null') }}
                        </div>
                    </th>
                    <td class="text-center border-0 parking_menu">
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <div id="paginate-page">
            {{ $parkings->withQueryString()->links() }}
        </div>
    </div>
    <div class="d-block m-auto pt-5 pb-5">
        <a href="{{ route('admin.index') }}" class="text-white btn btn-secondary px-5">
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
                {{ session()->get('createSuccess') }}
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
