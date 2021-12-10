@extends('owner::layouts.master')
@section('title', '認証コード入力＋パスワード')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/validate_register.css') }}">
@endsection
@section('content')
<div class="card-warning">
    <div class="card-body">
        <form method="POST" action="{{ route('change-password.update',  $ownerPass->member_cd) }}" id="form-reset-password" class="form-register" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="form-group row">
                <div class="offset-sm-6 col-sm-6">
                    <a class="btn btn-primary" href="{{ route('bank-info.show', $ownerPass->member_cd) }}">会員情報</a>
                    <a class="btn btn-primary" href="{{ route('member.edit', $ownerPass->member_cd) }}">口座情報</a>
                </div>
            </div>
            @if (session('success'))
                @include('owner::layouts.modal_success')
            @endif
            @if (session()->has('error'))
                <p class="text-danger">{{ session()->get('error') }}</p>
            @endif
            <div class="form-group row">
                <label class="col-md-2 font-weight-normal padding-top-label">新しいパスワード <b class="text-danger">*</b></label>
                <div class="col-md-5">
                    <input type="password" name="password" class="form-control">
                    @error ('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 font-weight-normal padding-top-label">パスワード再入力 <b class="text-danger">*</b></label>
                <div class="col-md-5">
                    <input type="password" name="password_confirmation" class="form-control">
                    @error ('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 font-weight-normal padding-top-label">前回更新日</label>
                <div class="col-md-5 pt-2">
                    <span>{{ $updated }}</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 col-lg-2"></div>
                <button id="showConfirm" type="submit" class="col-md-2 col-lg-2 btn btn-primary mt-4 ml-4 mr-5">更新</button>
                <a href="javascript:void(0)" class="col-md-2 col-lg-2 btn btn-secondary mt-4" data-toggle="modal" data-target="#modalCancel">キャンセル</a>
                <div class="col-md-4 col-lg-4"></div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
@include('owner::layouts.modal_confirm')
@include('owner::layouts.modal_cancel')
@endsection
@section('js')
    <script>
        var key = '{{ config('constants.KEY_GEOCODING_API') }}';
        var messageRequired = '{{ __("message.message_required") }}'
        var messageConfirmRequired = "{{ __('message.member.confirm_required') }}"
    </script>
    <script src="{{ mix('/js/find_address.js') }}"></script>
    <script src="{{ mix('/js/register_member.js') }}"></script>
    <script src="{{ mix('/js/validate_owner_reset_password.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
@endsection
