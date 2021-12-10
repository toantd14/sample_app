@php
use App\Models\Owner;
@endphp

@extends('admin::layouts.master')
@section('title', 'オーナー管理（検索）')
@section('content')
    <div class="desktop-device d-md-block d-none">
        <div class="title mt-4 ml-4">
            <h2>オーナー管理</h2>
        </div>
        <div class="box-input px-md-5 px-0 pt-3">
            <form id="form-search-owner" method="POST" action="{{ route('owners.search') }}">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    利用者区分
                </div>
                <div class="col-md-10">
                    <input type="radio" name="user_kbn" value="-1" class="mx-2" {{ old('user_kbn') === (string)Owner::KUBUN_ALL ? 'checked' : '' }} checked><label for="">すべて</label>
                    <input type="radio" name="user_kbn" value="0" class="mx-2" {{ old('user_kbn') === (string)Owner::KUBUN_PERSONAL ? 'checked' : '' }}><label for="">個人</label>
                    <input type="radio" name="user_kbn" value="1" class="mx-2" {{ old('user_kbn') ===  (string)Owner::KUBUN_CORPORATION ? 'checked' : '' }}><label for="">法人</label>
                </div>
                <div class="col-md-2">
                    ダミー区分
                </div>
                <div class="col-md-10">
                    <input type="radio" name="mgn_flg" value="-1" class="mx-2" {{ old('mgn_flg') === (string)Owner::MGN_FLG_ALL ? 'checked' : '' }} checked><label for="">すべて</label>
                    <input type="radio" name="mgn_flg" value="0" class="mx-2" {{ old('mgn_flg') === (string)Owner::MGN_FLG_DISABLE ? 'checked' : '' }}><label for="">オーナー</label>
                    <input type="radio" name="mgn_flg" value="1" class="mx-2" {{ old('mgn_flg') === (string)Owner::MGN_FLG_ENABLE ? 'checked' : '' }}><label for="">ダミー</label>
                </div>
                <div class="col-md-2">
                    名前（会社名）
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" value="{{ old('name_c') }}" name="name_c" class="form-control col-md-4">
                    </div>
                </div>
                <div class="col-md-2">
                    住所
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <select name="prefectures_cd" class="form-control col-md-4 d-inline-block mb-1">
                            <option value="">(都道府県）</option>
                            @foreach ($prefectures as $prefecture)
                                <option value="{{ $prefecture->prefectures_cd }}" {{ old('prefectures_cd') == $prefecture->prefectures_cd ? 'selected' : '' }} >{{ $prefecture->prefectures_name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="municipality_name" value="{{ old('municipality_name') }}" class="form-control col-md-5 d-inline-block" placeholder="市区町村郡 ">
                    </div>
                </div>
                <div class="col-md-2">
                    電話番号
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" value="{{ old('tel_no') }}" name="tel_no" class="form-control col-md-4 ">
                    </div>
                </div>
                <div class="col-md-2">
                    メールアドレス
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" name="mail_add" value="{{ old('mail_add') }}" class="form-control col-md-4">
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button id="submit-form" class="btn btn-primary w-25 mr-4">
                        検索
                    </button>
                    <a id="btn-back" href="{{ route('admin.index') }}" class="btn btn-secondary text-white w-25 mr-4">
                        戻る
                    </a>
                    <a href="{{ route('owners.create') }}" class="btn btn-success text-white w-25">
                        オーナー新規登録
                    </a>
                </div>
            </div>
            </form>
        </div>
        <div class="box-table mt-5">
            <div class="row">
                <div class="title col-md-6 col-xs-6 col-6 p-0">
                    <p>{{ $owners->total() }}件</p>
                </div>
                @if($owners->total() > $pageSize)
                <div class="col-md-6 col-xs-6 col-6 text-right p-0 mb-2">
                    <a href="{{ $owners->withQueryString()->previousPageUrl() }}" class="btn btn-secondary"><</a>
                    <a href="{{ $owners->withQueryString()->nextPageUrl() }}" class="btn btn-secondary">></a>
                </div>
                @endif
                <div id="table" class="overflow-auto w-100">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 10%">区分</th>
                            <th class="text-center" style="width: 20%">お名前(会社名)</th>
                            <th class="text-center" style="width: 20%">メールアドレス</th>
                            <th class="text-center" style="width: 20%">電話番号</th>
                            <th class="text-center" style="width: 25%">住所</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($owners->total() > 0)
                        @foreach($owners as $index => $owner)
                        <tr>
                            <th class="text-center">{{ $index + $owners->firstItem() }}</th>
                            <th class="text-center">{{ $owner->kubun == 0 ? '個人' : '法人' }}</th>
                            <th class="text-center">
                                <a href="{{ route('owners.edit', ['owner' => $owner->owner_cd]) }}">{{ $owner->name_c }}</a>
                            </th>
                            <th class="text-center">{{ $owner->mail_add}}</th>
                            <th class="text-center">{{ $owner->tel_no }}</th>
                            <th class="text-center">{{ $owner->prefecture->prefectures_name . $owner->municipality_name . $owner->townname_address }}</th>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <th colspan="6">
                                    <div class="alert alert-danger text-center" role="alert">
                                        {{ __('message.parking_lot.search_results_null') }}
                                    </div>
                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div id="paginate-page">
                        {{ $owners->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-device d-block d-md-none">
        <div class="title mb-2 text-center">
            <p>法人区分選択の入力項目</p>
        </div>
        <div class="box-input-mobile ">
            <div class="row">
                <div class="col-3">
                    法人名<b class="text-danger float-right">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text">
                </div>
                <div class="col-3">
                    担当部署
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text">
                </div>
                <div class="col-3">
                    担当者名<b class="text-danger float-right">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text">
                </div>
                <div class="col-3">
                    住所 <span class="float-right">〒</span>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                </div>
                <div class="col-3">
                    <b class="text-danger text-right d-block">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="(都道府県)">
                </div>
                <div class="col-3">
                    <b class="text-danger text-right d-block">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="(市区町村郡)">
                </div>
                <div class="col-3">
                    <b class="text-danger text-right d-block">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="(町域＋番地)">
                </div>
                <div class="col-3">
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="(建物等)">
                </div>
                <div class="col-3">
                    連絡先TEL <b class="text-danger float-right">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="">
                </div>
                <div class="col-3">
                    メール<b class="text-danger float-right">*</b>
                </div>
                <div class="col-9 form-group">
                    <input class="form-control" type="text" placeholder="">
                </div>
            </div>
        </div>
    </div>
@endsection
