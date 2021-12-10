@php
use App\Models\OwnerBank;
@endphp

@extends('owner::layouts.master')

@section('title', '口座情報')

@section('css')
    <link rel="stylesheet" href="{{ mix('/css/validate_register.css') }}">
@endsection

@section('content')
    <div class="card-warning">
        <div class="card-body">
            <div class="form-group row">
                <div class="offset-sm-6 col-sm-6">
                    <a class="btn btn-primary" href="{{ route('member.edit', $ownerBank->owner_cd) }}">会員情報</a>
                    <a class="btn btn-primary"
                       href="{{ route('change-password.edit', $ownerBank->owner_cd) }}">パスワード変種</a>
                </div>
            </div>
            @if(session('success'))
                @include('owner::layouts.modal_success')
            @endif
            @if(session('error'))
                <div class="alert alert-danger"> {{ session('error') }}</div>
            @endif
            <form id="form-owner-bank" method="POST" action="{{ route('bank-info.update', ['bank_info' => $ownerBank->owner_cd]) }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="m-auto">
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            金融機関名
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="bank_name"
                                   value="{{ old('bank_name') ?? $ownerBank->bank_name }}"
                                   placeholder="みずほ銀行">
                            @if ($errors->any() && $errors->has('bank_name'))
                                <div class="text-danger">{{ $errors->first('bank_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            金融機関コード
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control col-md-4" name="bank_cd"
                                   value="{{ old('bank_cd') ?? $ownerBank->bank_cd }}" placeholder="999">
                            @if ($errors->any() && $errors->has('bank_cd'))
                                <div class="text-danger">{{ $errors->first('bank_cd') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            支店名
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="branch_name"
                                   value="{{ old('branch_name') ?? $ownerBank->branch_name }}" placeholder="銀座支店">
                            @if ($errors->any() && $errors->has('branch_name'))
                                <div class="text-danger">{{ $errors->first('branch_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            支店コード
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control col-md-4" name="branch_cd"
                                   value="{{ old('branch_cd') ?? $ownerBank->branch_cd }}" placeholder="9999">
                            @if ($errors->any() && $errors->has('branch_cd'))
                                <div class="text-danger">{{ $errors->first('branch_cd') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            口座種別
                        </label>
                        <div class="col-md-10 pt-2">
                            @if ($ownerBank->account_type == OwnerBank::NORMAL_ACCOUNT)
                                <input class="role" type="radio" name="account_type" value="{{ OwnerBank::NORMAL_ACCOUNT }}" checked><label class="mr-3 ml-1">普通</label>
                                <input class="role" id="company" name="account_type" value="{{ OwnerBank::TRADE_ACCOUNT }}" type="radio"><label class="mr-3 ml-1">当座</label>
                            @else
                                <input class="role" type="radio" name="account_type" value="{{ OwnerBank::NORMAL_ACCOUNT }}"><label class="mr-3 ml-1">普通</label>
                                <input class="role" type="radio" id="company" name="account_type" value="{{ OwnerBank::TRADE_ACCOUNT }}" checked><label class="mr-3 ml-1">当座</label>
                            @endif
                            @if($errors->any() && $errors->has('account_type'))
                                <p class="text-danger error mb-2 mt-2">{{ $errors->first('account_type') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            口座名
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_name"
                                   value="{{ old('account_name') ?? $ownerBank->account_name }}" placeholder="株式会社ＮＮＮ">
                            @if ($errors->any() && $errors->has('account_name'))
                                <div class="text-danger">{{ $errors->first('account_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            口座名フリガナ
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_kana"
                                   value="{{ old('account_kana') ?? $ownerBank->account_kana }}" placeholder="カ）エヌエヌエヌ">
                            @if ($errors->any() && $errors->has('account_kana'))
                                <div class="text-danger">{{ $errors->first('account_kana') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            口座番号
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_no" value="{{ old('account_no') ?? $ownerBank->account_no }}" placeholder="">
                            @error ('account_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            登録日
                        </label>
                        <div class="col-md-10 pt-2">
                            <p>{{ date_format($ownerBank->created_at, config('constants.DATE.FORMAT_YEAR_FIRST')) }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pl-5 padding-top-label">
                            更新日
                        </label>
                        <div class="col-md-10 pt-2">
                            <p>{{ date_format($ownerBank->updated_at, config('constants.DATE.FORMAT_YEAR_FIRST')) }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 col-lg-2"></div>
                        <div class="col-md-10 col-lg-10 text-center">
                            <button class="text-white btn btn-primary w-25 mt-4 ml-4 mr-5">更新</button>
                            <a data-toggle="modal" data-target="#modalCancel" href=""
                               class="w-25 btn btn-secondary mt-4">キャンセル</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('owner::layouts.modal_confirm')
    @include('owner::layouts.modal_cancel')
@endsection
@section('js')
    <script>
        var messageRequired = '{{ __('message.member.required') }}'
    </script>
    <script>
        var radioValue = {{ old('account_type') ?? $ownerBank->account_type }};
        $('input[name="account_type"][value=' + radioValue + ']').attr('checked', 'checked');
    </script>
    <script src="{{ mix('/js/validate_owner_bank.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
@endsection

