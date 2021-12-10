@php
use App\Models\MstUser
@endphp

@extends('admin::layouts.master')
@section('title', '利用者管理（検索）')
@section('content')
    <div class="desktop-device d-md-block d-none">
        <div class="title mt-4 ml-4">
            <h2>利用者管理</h2>
        </div>
        <div class="box-input px-md-5 px-0 pt-3">
            <form id="form-search-owner" method="GET" action="{{ route('users.search') }}">
                <div class="row">
                    <div class="col-md-2">
                        利用者区分
                    </div>
                    <div class="col-md-10">
                        <input type="radio" name="user_kbn" value="{{ config('constants.KUBUN_SEARCH.ALL') }}"
                               class="mx-2" checked><label for="">すべて</label>
                        <input type="radio" name="user_kbn" value="{{ config('constants.KUBUN_SEARCH.PERSONAL') }}"
                               class="mx-2" {{ old('user_kbn') === (string)config('constants.KUBUN_SEARCH.PERSONAL') ? 'checked' : '' }}><label for="">個人</label>
                        <input type="radio" name="user_kbn" value="{{ config('constants.KUBUN_SEARCH.COMPANY') }}"
                               class="mx-2" {{ old('user_kbn') === (string)config('constants.KUBUN_SEARCH.COMPANY') ? 'checked' : '' }}><label for="">法人</label>
                    </div>
                    <div class="col-md-2">
                        SNS区分
                    </div>
                    <div class="col-md-10">
                        <input type="radio" name="howto_use" value="{{ config('constants.SNS_SEARCH.ALL') }}"
                               class="mx-2" checked><label for="">すべて</label>
                        <input type="radio" name="howto_use" value="{{ config('constants.SNS_SEARCH.FACEBOOK') }}"
                               class="mx-2" {{ old('howto_use') === (string)config('constants.SNS_SEARCH.FACEBOOK') ? 'checked' : '' }}><label for="">facebook</label>
                        <input type="radio" name="howto_use" value="{{ config('constants.SNS_SEARCH.GOOGLE') }}"
                               class="mx-2" {{ old('howto_use') === (string)config('constants.SNS_SEARCH.GOOGLE') ? 'checked' : '' }}><label for="">google</label>
                        <input type="radio" name="howto_use" value="{{ config('constants.SNS_SEARCH.LINE') }}"
                               class="mx-2" {{ old('howto_use') === (string)config('constants.SNS_SEARCH.LINE') ? 'checked' : '' }}><label for="">LINE</label>
                        <input type="radio" name="howto_use" value="{{ config('constants.SNS_SEARCH.ID_PASSWORD') }}"
                               class="mx-2" {{ old('howto_use') === (string)config('constants.SNS_SEARCH.ID_PASSWORD') ? 'checked' : '' }}><label for="">IDログイン</label>
                    </div>
                    <div class="col-md-2">
                        名前（会社名）
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" value="{{ old('corporate_name') }}" name="corporate_name" class="form-control col-md-6">
                        </div>
                    </div>
                    <div class="col-md-2">
                        住所
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <select name="prefectures_cd" class="form-control col-md-4 d-inline-block pt-1">
                                <option value="">(都道府県）</option>
                                @foreach ($prefectures as $prefecture)
                                    <option value="{{ $prefecture->prefectures_cd }}" {{ old('prefectures_cd') == $prefecture->prefectures_cd ? 'selected' : '' }} >{{ $prefecture->prefectures_name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="municipality_name" value="{{ old('municipality_name') }}" class="form-control col-md-6 d-inline-block" placeholder="市区町村郡 ">
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
                            <input type="text" name="mail_add" value="{{ old('mail_add') }}" class="form-control col-md-6">
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button id="submit-form" class="btn btn-primary w-25">
                            検索
                        </button>
                        <a href="{{ route('admin.index') }}" id="btn-back" class="btn btn-secondary w-25 text-white">
                            戻る
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-table mt-5 col-lg-12">
            <div class="row">
                <div class="title col-md-6 col-xs-6 col-6 p-0 d-flex">
                    <span class="mt-2">{{ $users->total() }}件</span>
                </div>
                @if($users->total() > $users->perPage())
                <div class="col-md-6 col-xs-6 col-6 text-right p-0 mb-2">
                    <a href="{{ $users->withQueryString()->previousPageUrl() }}" class="btn btn-secondary"><</a>
                    <a href="{{ $users->withQueryString()->nextPageUrl() }}" class="btn btn-secondary">></a>
                </div>
                @endif
                <div id="table" class="overflow-auto w-100">
                    <table class="table table-bordered border-0">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 7%">区分</th>
                            <th class="text-center" style="width: 12%">SNS区分</th>
                            <th class="text-center" style="width: 12%">お名前(会社名)</th>
                            <th class="text-center" style="width: 12%">メールアドレス</th>
                            <th class="text-center" style="width: 12%">電話番号</th>
                            <th class="text-center" style="width: 25%">住所</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if ($users->total() > 0)
                            @foreach($users as $index => $user)
                            <tr>
                                <th class="text-center">{{ $index + $users->firstItem() }}</th>
                                <th class="text-center">{{ $user->user_kbn == config('constants.KUBUN_SEARCH.PERSONAL') ? '個人' : '法人' }}</th>
                                <th class="text-center">
                                    <a href="{{ route('get.users.edit', $user->user_cd) }}">
                                        {{ MstUser::TYPE_LOGIN[$user->howto_use] }}
                                    </a>
                                </th>
                                <th class="text-center">
                                    {{ $user->user_kbn == MstUser::USER_KUBUN_PERSONAL ? $user->name_mei.$user->name_sei : $user->corporate_name }}
                                </th>
                                <th class="text-center">{{ $user->mail_add }}</th>
                                <th class="text-center">{{ $user->tel_no }}</th>
                                <th class="text-center">{{ $user->prefecture->prefectures_name . $user->municipality_name . $user->townname_address }}</th>
                            </tr>
                            @endforeach
                            @else
                                <tr class="text-center">
                                    <th colspan="9" class="text-center">
                                        <div class="alert alert-danger text-center" role="alert">
                                            {{ __('message.parking_lot.search_results_null') }}
                                        </div>
                                    </th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div id="paginate-page">
                        {{ $users->withQueryString()->links() }}
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
                    <input class="form-control" type="text" placeholder="9999999">
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
