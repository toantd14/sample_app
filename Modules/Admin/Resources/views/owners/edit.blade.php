@extends('admin::layouts.master')
@section('title', '新規オーナー変更')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/admin/loading.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/validate_register.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/register-parking.css') }}">
@endsection
@section('content')
    <div id="loader" class="d-none">
    </div>
    <div class="title mt-4 ml-4">
        <h2>
            オーナー情報編集
        </h2>
    </div>
    <div class="card-warning" id="box-form-register">
        <div class="card-body">
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif
            <p class="text-danger error exception mt-2"></p>

            <form id="form-register" action="{{ route('owners.update', $owner->owner_cd) }}"
                enctype="multipart/form-data">
            @csrf
                <input name="_method" type="hidden" value="PATCH">
            <!-- text input -->
                <div class="form-group row">
                    <a href="{{ route('owner-banks.edit', ['id' => $ownerCD]) }}" class="ml-auto col-lg-3 col-sm-3 btn btn-primary mt-4 mr-2">
                        口座情報
                    </a>
                    <a href="{{ route('owner-password.edit', ['id' => $ownerCD]) }}" class="col-lg-3 col-sm-3 btn btn-primary mt-4">
                        パスワード変種
                    </a>
                </div>
                @if (session()->has('editErrors'))
                    <div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
                @endif
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">管理区分　<b class="text-danger">*</b></label>
                    <div class="col-md-10">
                        @if ($owner->mgn_flg == 0)
                            <input class="role" type="radio" name="mgn_flg" value="0" checked><label class="mr-3 ml-1">本契約</label>
                            <input class="role" type="radio" name="mgn_flg" value="1"><label class="mr-3 ml-1">ダミー</label>
                        @else
                            <input class="role" type="radio" name="mgn_flg" value="0"><label class="mr-3 ml-1">本契約</label>
                            <input class="role" type="radio" name="mgn_flg" value="1" checked><label class="mr-3 ml-1">ダミー</label>
                        @endif
                        @if($errors->any() && $errors->has('kubun'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('kubun') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">区分　<b class="text-danger">*</b></label>
                    <div class="col-md-10">
                        @if ($owner->kubun == \App\Models\Owner::PERSONAL)
                            <input class="role" type="radio" name="kubun" value="0" checked><label class="mr-3 ml-1">個人</label>
                            <input class="role" id="company" name="kubun" value="1" type="radio"><label class="mr-3 ml-1">法人</label>
                        @else
                            <input class="role" type="radio" name="kubun" value="0"><label class="mr-3 ml-1">個人</label>
                            <input class="role" type="radio" id="company" name="kubun" value="1" checked><label class="mr-3 ml-1">法人</label>
                        @endif
                        @if($errors->any() && $errors->has('kubun'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('kubun') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">お名前 <b class="text-danger">*</b></label>
                    <div class="col-md-6">
                        <input type="text" name="name_c" class="form-control" placeholder="株式会社ＡＡＡＡ" value="{{ old('name_c') ?? $owner->name_c }}">
                        @if($errors->any() && $errors->has('name_c'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('name_c') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="name_c"></p>
                    </div>
                    <div class="col-md-4">（法人の場合、法人名を入力して下さい。）</div>
                </div>
                <div id="info-company">
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">担当者名  <b class="text-danger">*</b></label>
                        <div class="col-md-5">
                            <input type="text" name="person_man" placeholder="ＮＮ ＮＮＮ" value="{{ old('person_man') ?? $owner->person_man }}" class="form-control">
                            @if($errors->any() && $errors->has('person_man'))
                                <p class="text-danger error mb-2 mt-2">{{ $errors->first('person_man') }}</p>
                            @endif
                            <p class="text-danger error mb-2 mt-2" id="person_man"></p>
                        </div>
                        <div class="col-md-4">
                            （法人の連絡ご担当者名を入力して下さい。）
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">部署名</label>
                        <div class="col-md-5">
                            <input type="text" name="department" value="{{ old('department') ?? $owner->department }}" class="form-control">
                            @if($errors->any() && $errors->has('department'))
                                <p class="text-danger error mb-2 mt-2">{{ $errors->first('department') }}</p>
                            @endif
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">法人HP-URL</label>
                        <div class="col-md-6">
                            <input type="text" name="hp_url" placeholder="www.abcd.co.jp" value="{{ old('hp_url') ?? $owner->hp_url }}" class="form-control">
                            @if($errors->any() && $errors->has('hp_url'))
                                <p class="text-danger error mb-2 mt-2">{{ $errors->first('hp_url') }}</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            （ホームページのURLを入力して下さい）
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">メールアドレス  <b class="text-danger">*</b></label>
                    <div class="col-md-6">
                        <input type="text" name="mail_add" placeholder="xxxx@gmail.com" value="{{ old('mail_add') ?? $owner->mail_add }}" class="form-control">
                        @if($errors->any() && $errors->has('mail_add'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('mail_add') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="mail_add"></p>
                    </div>
                    <div class="col-md-4">
                        （ログインIDとなります。）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">住所 <b class="text-danger">*</b><span class="float-right">〒</span></label>
                    <div class="col-md-5">
                        <input type="text" name="zip_cd" value="{{ old('zip_cd') ?? $owner->zip_cd }}" class="form-control zip_code" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                        @if($errors->any() && $errors->has('zip_cd'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('zip_cd') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="zip_cd"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5">
                        <input type="text" name="prefectures" placeholder="東京都" value="{{ old('prefectures') ?? $prefecture->prefectures_name }}" class="form-control prefectures">
                        @if($errors->any() && $errors->has('prefectures'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('prefectures') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="prefectures"></p>
                    </div>
                    <div class="col-md-5">
                        （都道府県）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5">
                        <input type="text" placeholder="港区" name="municipality_name" value="{{ old('municipality_name') ?? $owner->municipality_name }}" class="form-control municipality_name">
                        @if($errors->any() && $errors->has('municipality_name'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('municipality_name') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="municipality_name"></p>
                    </div>
                    <div class="col-md-5">
                        （市区町村郡）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5">
                        <input type="text" placeholder="六本木1-1-1" name="townname_address" value="{{ old('townname_address') ?? $owner->townname_address }}" class="form-control townname_address">
                        @if($errors->any() && $errors->has('townname_address'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('townname_address') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="townname_address"></p>
                    </div>
                    <div class="col-md-5">
                        （町域名＋番地）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2"></label>
                    <div class="col-md-5">
                        <input type="text" placeholder="ヒルズタワー10F" value="{{ old('building_name') ?? $owner->building_name }}" name="building_name" class="form-control">
                        @if($errors->any() && $errors->has('building_name'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('building_name') }}</p>
                        @endif
                    </div>
                    <div class="col-md-5">
                        （建物等）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">電話番号<b class="text-danger">*</b></label>
                    <div class="col-md-5">
                        <input type="text" placeholder="ハイフン無しで入力" value="{{ old('tel_no') ?? $owner->tel_no }}" name="tel_no" class="form-control">
                        @if($errors->any() && $errors->has('tel_no'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('tel_no') }}</p>
                        @endif
                        <p class="text-danger error mb-2 mt-2" id="tel_no"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">FAX番号</label>
                    <div class="col-md-5">
                        <input type="text" name="fax_no" value="{{ old('fax_no') ?? $owner->fax_no }}" class="form-control">
                        @if($errors->any() && $errors->has('fax_no'))
                            <p class="text-danger error mb-2 mt-2">{{ $errors->first('fax_no') }}</p>
                        @endif
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal pl-5 pt-2">印鑑</label>
                    <div class="text-center col-md-5">
                        <div class="d-flex justify-content-center align-items-center" id="div-input-image1" @if($owner->stamp)
                        style="display: none !important;"
                            @endif>
                            <label for="btnEditInputUpload1" id="file-label-images1" class="file-label-images1 file-label-images" style="max-width: 100% !important;">クリックまたはドラッグしてファイルを指定</label>
                            <input type="file" id="btnEditInputUpload1" name="stamp" class="file-input-images1 file-input-images" accept="image/*" value="" image="1"
                                   style="width: 100% !important; cursor: pointer">
                        </div>
                        <div id="filePreviewEdit1" class="p-2 file-preview-area2 file-preview-area" @if($owner->stamp)
                        style="display: block"
                            @endif>
                            <img class="img-upload-preview1 img-preview" src="data:image/png;base64,{{ $owner->stamp }}" alt="preview uploaded file">
                            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-x-circle-fill delete-btn" image="1" fill="currentColor">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z" />
                            </svg>
                            <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                        </div>
                        @if($errors->any() && $errors->has('image.1'))
                            <p class="text-danger float-left mt-2">{{$errors->first('image.1')}}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-3"></div>
                    <button id="showConfirm" class="col-lg-3 col-sm-3 btn btn-primary mt-4">
                        登録
                    </button>
                    <div class="col-lg-1 col-sm-1"></div>
                    <a href="javascript:void(0)" data-toggle="modal"  data-target="#modalCancel" class="text-white col-lg-3 col-sm-3 btn btn-secondary mt-4">
                        キャンセル
                    </a>
                    <div class="col-lg-4 col-sm-4"></div>
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
                    <button id="confirm-button" data-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary w-25">OK</button>
                    <button id="cancel" type="button" class="btn btn-secondary w-25" data-dismiss="modal" aria-label="Close">
                        {{ __('message.register.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="successRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body modal-notification" id="successRegisterContent">

                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="url-certification btn btn-success">OK</a>
                </div>
            </div>
        </div>
    </div>
@include('admin::layouts.modal_confirm')
@include('admin::layouts.modal_cancel')
@endsection
@section('js')
    <script>
        var key = '{{ config('constants.KEY_GEOCODING_API') }}';
        var messageRegisterSuccess = '{{ __('message.register.success') }}';
        var messageRequired = '{{ __('message.member.required') }}';
        var messageExit = '{{ __('message.register.exit') }}';
        var checkZipCode = true;
        let messageSelectRequired = 'asdasd';
    </script>
    <script src="{{ mix('/js/admin/find_address.js') }}"></script>
    <script src="{{ mix('/js/admin/edit_owner.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
    <script src="{{ mix('/js/admin/moment.min.js') }}"></script>
    <script src="{{ mix('/js/common/common-image-video-upload.js') }}"></script>
@endsection
