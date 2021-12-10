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
                    <a class="btn btn-primary" href="{{ route('member.edit', $ownerCd) }}">会員情報</a>
                    <a class="btn btn-primary"
                       href="{{ route('change-password.edit', $ownerCd) }}">パスワード変種</a>
                </div>
            </div>
            @if(session('success'))
                @include('owner::layouts.modal_success')
            @endif
            @if(session('error'))
                <div class="alert alert-danger"> {{ session('error') }}</div>
            @endif
            <form id="form-owner-bank" method="POST" action="{{ route('bank-info.store')}}">
                @csrf
                <div class="m-auto">
                    <div class="form-group row">
                        <lable class="col-md-2">
                            金融機関名
                            <b class="text-danger">*</b>
                        </lable>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" placeholder="みずほ銀行">
                            @if ($errors->any() && $errors->has('bank_name'))
                                <div class="text-danger">{{ $errors->first('bank_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            金融機関コード
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control col-md-4" name="bank_cd" value="{{ old('bank_cd') }}" placeholder="999">
                            @if ($errors->any() && $errors->has('bank_cd'))
                                <div class="text-danger">{{ $errors->first('bank_cd') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            支店名
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="branch_name" value="{{ old('branch_name') }}"  placeholder="銀座支店">
                            @if ($errors->any() && $errors->has('branch_name'))
                                <div class="text-danger">{{ $errors->first('branch_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            支店コード
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control col-md-4" name="branch_cd" value="{{ old('branch_cd') }}"  placeholder="9999">
                            @if ($errors->any() && $errors->has('branch_cd'))
                                <div class="text-danger">{{ $errors->first('branch_cd') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            口座種別
                        </label>
                        <div class="col-md-10">
                            <input type="radio" name="account_type" {{ old('account_type') == OwnerBank::NORMAL_ACCOUNT ? 'checked' : ''  }} value="0" checked><label class="ml-2 mr-4">普通</label>
                            <input type="radio" name="account_type" {{ old('account_type') == OwnerBank::TRADE_ACCOUNT ? 'checked' : ''  }} value="1"><label class="ml-2">当座</label>
                            @if ($errors->any() && $errors->has('account_type'))
                                <div class="text-danger">{{ $errors->first('account_type') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            口座名
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_name" value="{{ old('account_name') }}" placeholder="株式会社ＮＮＮ">
                            @if ($errors->any() && $errors->has('account_name'))
                                <div class="text-danger">{{ $errors->first('account_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            口座名フリガナ
                            <b class="text-danger">*</b>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_kana" value="{{ old('account_kana') }}" placeholder="カ）エヌエヌエヌ">
                            @if ($errors->any() && $errors->has('account_kana'))
                                <div class="text-danger">{{ $errors->first('account_kana') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">
                            口座番号
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="account_no" value="{{ old('account_no') }}" placeholder="">
                            @error ('account_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 col-lg-2"></div>
                        <div class="col-md-10 col-lg-10 text-center">
                            <button class="text-white btn btn-primary w-25 mt-4 ml-4 mr-5">更新</button>
                            <a data-toggle="modal" data-target="#modalCancel" href="" class="w-25 btn btn-secondary mt-4">キャンセル</a>
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
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
    <script src="{{ mix('/js/validate_owner_bank.js') }}"></script>
@endsection
