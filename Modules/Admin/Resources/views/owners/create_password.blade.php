@extends('admin::layouts.master')
@section('title', 'パスワード変更')
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

            <form id="form-reset-password">
                <!-- text input -->
                <div class="form-group row">
                    <a href="{{ route('owners.create') }}" class="ml-auto col-lg-3 col-sm-3 btn btn-primary mt-4 mr-2">
                        会員情報
                    </a>
                    <a href="{{ route('owner-banks.create', ['owner' => $ownerCD]) }}" class="col-lg-3 col-sm-3 btn btn-primary mt-4">
                        口座情報
                    </a>
                </div>
                @csrf
                <div class="form-group row mt-5">
                    <label class="col-md-2 font-weight-normal">新しいパスワード<b class="text-danger">*</b></label>
                    <div class="col-md-5">
                        <input type="password" id="password" name="password" class="form-control">
                        @if ($errors->any())
                            <div class="text-danger">{{ $errors->first() }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">パスワード再入力 <b class="text-danger">*</b></label>
                    <div class="col-md-5">
                        <input type="password" name="password_confirmation" class="form-control">
                        @if ($errors->any() && $errors->has('password_confirmation'))
                            <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
                @if(isset($updated))
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">前回更新日</label>
                        <div class="col-md-7">
                            <p>{{ $updated }}</p>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-3"></div>
                    <button id="showConfirm" class="col-lg-2 col-sm-2 btn btn-primary mt-4">
                        登録
                    </button>
                    <div class="col-lg-1 col-sm-1"></div>
                    <a href="{{ route('admin.index') }}" class="text-white col-lg-2 col-sm-2 btn btn-secondary mt-4">
                        キャンセル
                    </a>
                    <div class="col-lg-4 col-sm-4"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button id="btn-confirm" data-url="{{ route('owner-password.update', ['id' => $ownerCD]) }}" data-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary w-25">OK</button>
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
    </script>
    <script src="{{ mix('/js/admin/edit_owner_password.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
@endsection
