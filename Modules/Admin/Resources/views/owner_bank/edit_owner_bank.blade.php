@extends('admin::layouts.master')
@section('title', '新規オーナー変更')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/admin/loading.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/validate_register.css') }}">
@endsection
@section('content')
    <div id="loader" class="d-none">
    </div>
    <div class="card-warning" id="box-form-register">
        <div class="card-body">
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif
            <p class="text-danger error exception mt-2"></p>

            <form id="form-owner-bank">
                <!-- text input -->
                <div class="form-group row">
                    <a href="{{ route('owners.edit', ['owner' => $ownerCD]) }}" class="ml-auto col-lg-3 col-4 btn btn-primary mt-4 mr-2">
                        会員情報
                    </a>
                    <a href="{{ route('owner-password.edit', ['id' => $ownerCD]) }}" class="col-lg-3 col-4 btn btn-primary mt-4">
                        パスワード変種
                    </a>
                </div>
                @csrf
                @if (session()->has('editErrors'))
                    <div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
                @endif
                <div class="form-group row mt-5">
                    <label class="offset-lg-1 col-lg-2 col-5 pt-2 pl-5 font-weight-normal">金融機関名<b class="text-danger">*</b></label>
                    <div class="col-lg-7 col-7">
                        <input type="text" name="bank_name" class="form-control" placeholder="みずほ銀行" value="{{ old('bank_name') ?? (isset($ownerBank) ? $ownerBank->bank_name : '') }}">
                        @if($errors->any() && $errors->has('bank_name'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('bank_name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 col-lg-2 col-5 pt-2 pl-5 font-weight-normal">金融機関コード <b class="text-danger">*</b></label>
                    <div class="col-lg-3 col-4">
                        <input type="text" name="bank_cd" class="form-control" placeholder="999" value="{{ old('bank_cd') ?? (isset($ownerBank) ? $ownerBank->bank_cd : '') }}">
                        @if($errors->any() && $errors->has('bank_cd'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('bank_cd') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 col-lg-2 col-5 pt-2 pl-5 font-weight-normal">支店名<b class="text-danger">*</b></label>
                    <div class="col-lg-7 col-7">
                        <input type="text" name="branch_name" class="form-control" placeholder="銀座支店" value="{{ old('branch_name') ?? (isset($ownerBank) ? $ownerBank->branch_name : '') }}">
                        @if($errors->any() && $errors->has('branch_name'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('branch_name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 col-lg-2 col-5 pt-2 pl-5 font-weight-normal">支店コード<b class="text-danger">*</b></label>
                    <div class="col-lg-3 col-4">
                        <input type="text" name="branch_cd" class="form-control" placeholder="9999" value="{{ old('branch_cd') ?? (isset($ownerBank) ? $ownerBank->branch_cd : '') }}">
                        @if($errors->any() && $errors->has('branch_cd'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('branch_cd') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 col-lg-2 col-5 pl-5 font-weight-normal">口座種別</label>
                    <div class="col-lg-8 col-7">
                        @if(!isset($ownerBank))
                            <input class="role" type="radio" name="account_type" value="0" checked><label class="mr-3 ml-1">普通</label>
                            <input class="role" id="company" name="account_type" value="1" type="radio"><label class="mr-3 ml-1">当座</label>
                        @elseif ($ownerBank->account_type == 0)
                            <input class="role" type="radio" name="account_type" value="0" checked><label class="mr-3 ml-1">普通</label>
                            <input class="role" id="company" name="account_type" value="1" type="radio"><label class="mr-3 ml-1">当座</label>
                        @else
                            <input class="role" type="radio" name="account_type" value="0"><label class="mr-3 ml-1">普通</label>
                            <input class="role" type="radio" id="company" name="account_type" value="1" checked><label class="mr-3 ml-1">当座</label>
                        @endif
                        @if($errors->any() && $errors->has('account_type'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('account_type') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="pt-2 pl-5 offset-lg-1 col-lg-2 col-5 font-weight-normal">口座名<b class="text-danger">*</b></label>
                    <div class="col-lg-7 col-7">
                        <input type="text" name="account_name" class="form-control" placeholder="株式会社ＮＮＮ" value="{{ old('account_name') ?? (isset($ownerBank) ? $ownerBank->account_name : '') }}">
                        @if($errors->any() && $errors->has('account_name'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('account_name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 pt-2 pl-5 col-5 col-lg-2 font-weight-normal">口座名フリガナ<b class="text-danger">*</b></label>
                    <div class="col-lg-7 col-7">
                        <input type="text" name="account_kana" class="form-control" placeholder="カ）エヌエヌエヌ" value="{{ old('account_kana') ?? (isset($ownerBank) ? $ownerBank->account_kana : '') }}">
                        @if($errors->any() && $errors->has('account_kana'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('account_kana') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="offset-lg-1 pt-2 pl-5 col-5 col-lg-2 font-weight-normal">
                        口座番号
                    </label>
                    <div class="col-lg-7 col-7">
                        <input type="text" class="form-control" name="account_no" value="{{ old('account_no') ?? $ownerBank->account_no }}" placeholder="">
                        @error ('account_no')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @if(isset($updated) && isset($created))
                    <div class="form-group row">
                        <label class="offset-lg-1 pl-5 col-lg-2 col-5 font-weight-normal">登録日</label>
                        <div class="col-lg-7 col-7">
                            <p id="created_at">{{ $created }}</p>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="offset-lg-1 col-lg-2 pl-5 col-5 font-weight-normal">更新日</label>
                        <div class="col-lg-7 col-7">
                            <p id="update_at">{{ $updated }}</p>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="pl-5 col-5 col-lg-2 offset-lg-1 font-weight-normal">登録日</label>
                        <div class="col-lg-7 col-7">
                            <p id="created_at">{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}</p>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="pl-5 col-5 offset-lg-1 col-lg-2 font-weight-normal">更新日</label>
                        <div class="col-lg-7 col-7">
                            <p id="update_at">{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}</p>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-3"></div>
                    <button id="showConfirm" class="col-lg-2 col-sm-3 btn btn-primary mt-4">
                        登録
                    </button>
                    <div class="col-lg-1 col-sm-1"></div>
                    <a href="{{ route('owners.index') }}" class="text-white col-lg-2 col-sm-3 btn btn-secondary mt-4">
                        キャンセル
                    </a>
                    <div class="col-lg-4 col-sm-3"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">
                        {{ __('message.register.confirm') }}
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button id="confirm-button" data-url="{{ route('owner-banks.update', $ownerCD) }}" data-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary w-25">OK</button>
                    <button id="cancel" type="button" class="btn btn-secondary w-25" data-dismiss="modal" aria-label="Close">
                        {{ __('message.register.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="errorUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body modal-notification" id="errorUpdateContent">
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="url-certification btn btn-danger">OK</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="successUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body modal-notification" id="successUpdateContent">
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="url-certification btn btn-success">OK</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var messageRequired = '{{ __('message.member.required') }}';
        @if(isset($updated) && isset($created))
            var isUpdateCreatedAtField = false;
        @else
            var isUpdateCreatedAtField = true;
        @endif
    </script>
    <script src="{{ mix('/js/admin/edit_owner_bank.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
@endsection
