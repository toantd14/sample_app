@extends('owner::layouts.master')
@section('title', '新規オーナー登録')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/loading.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/validate_register.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/register-owner.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/register-parking.css') }}">
@endsection
@section('content')
    <div id="loader" class="d-none">
    </div>
    <div class="card-warning" id="box-form-register">
        <div class="card-body pl-0 pr-0">
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif
                <p class="text-danger error exception mt-2"></p>

                <form id="form-register" url="{{ route('member.post.register', ['member' => request()->member ?? '']) }}" enctype="multipart/form-data" class="form-check-code">
                <!-- text input -->
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">区分　<b class="text-danger">*</b></label>
                    <div class="col-md-10 col-8">
                        <input class="role" type="radio" name="kubun" value="0" ><label class="mr-3 ml-1">個人</label>
                        <input class="role" id="company" type="radio" name="kubun" value="1"><label class="mr-3 ml-1">法人</label>

                        <p class="text-danger error kubun mt-2"></p>
                    </div>
                </div>
                @if (request()->member == config('owner.role_user'))
                    <div id="user-name">
                        <div class="form-group row">
                            <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">お名前 <b class="text-danger">*</b></label>
                            <div class="col-md-3 col-8">
                                <input type="text" name="name_c[0]" class="form-control" placeholder="（姓）" disabled>
                                <p class="text-danger error name_c mt-2"></p>
                            </div>
                            <div class="div-hident col-4"><span class="float-right"><b class="text-danger">*</b></span></div>
                            <div class="col-md-3 col-8">
                                <input type="text" name="name_c[1]" class="form-control" placeholder="（名）" disabled>
                                <p class="text-danger error name_c mt-2"></p>
                            </div>
                        </div>
                    </div>
                    <div id="user-company">
                        <div class="form-group row">
                            <label class="col-md-2 pr-0 pl-5 font-weight-normal">ご契約名 <b class="text-danger">*</b></label>
                            <div class="col-md-6">
                            <input type="text" name="name_c[2]" class="form-control" disabled>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                        <div class="col-md-4">
                            （法人の場合、法人名を入力して下さい）
                        </div>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">ご契約名 <b class="text-danger">*</b></label>
                        <div class="col-md-6 col-8">
                            <input type="text" name="name_c" class="form-control" disabled>
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                        <div class="div-hident col-4"></div>
                        <div class="col-md-4 col-8">
                            （法人の場合、法人名を入力して下さい）
                        </div>
                    </div>
                @endif
                <div id="info-company">
                    <div class="form-group row">
                        <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">担当者名  <b class="text-danger">*</b></label>
                        <div class="col-md-5 col-8">
                            <input type="text" name="person_man" class="form-control" disabled>
                            <p class="text-danger error person_man mt-2"></p>

                        </div>
                        <div class="div-hident col-4"></div>
                        <div class="col-md-5 col-8">
                            （法人の連絡ご担当者名を入力して下さい）
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">部署名</label>
                        <div class="col-md-5 col-8">
                            <input type="text" name="department" class="form-control" disabled>
                            <p class="mt-5"></p>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">法人HP-URL</label>
                        <div class="col-md-6 col-8">
                            <input type="text" name="hp_url" class="form-control" disabled>
                            <p class="text-danger error hp_url mt-2"></p>
                        </div>
                        <div class="div-hident col-4"></div>
                        <div class="col-md-4 col-8">
                            （ホームページのURLを入力して下さい）
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 col-4 pl-5 font-weight-normal">メールアドレス  <b class="text-danger">*</b></label>
                    <div class="col-md-6 col-8">
                        <input type="text" name="mail_add" class="form-control" disabled>
                        <p class="text-danger error mail_add mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-4 col-8">
                        （ログインIDとなります。）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">住所 <b class="text-danger">*</b><span class="float-right">〒</span></label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="zip_cd" class="form-control zip_code" disabled placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                            <p class="text-danger error zip_cd mt-2"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pl-5 pr-1 col-4"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="prefectures" class="form-control prefectures" disabled>
                        <p class="text-danger error prefectures mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-5 col-8">
                        （都道府県）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-1 pl-5 col-4"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="municipality_name" class="form-control municipality_name" disabled>
                        <p class="text-danger error municipality_name mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-5 col-8">
                        （市区町村郡）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-1 pl-5 col-4"><span class="float-right"><b class="text-danger">*</b></span></label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="townname_address" class="form-control townname_address" disabled>
                        <p class="text-danger error townname_address mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-5 col-8">
                        （町域名＋番地）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 col-4"></label>
                    <div class="col-md-5 col-8 mb-3">
                        <input type="text" name="building_name" class="form-control" disabled>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-5 col-8">
                        （建物等）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">電話番号<b class="text-danger">*</b></label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="tel_no" class="form-control" placeholder="ハイフン無しで入力" disabled>
                        <p class="text-danger error tel_no mt-2"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 col-4 font-weight-normal">FAX番号</label>
                    <div class="col-md-5 col-8">
                        <input type="text" name="fax_no" class="form-control" disabled>
                        <p class="text-danger error fax_no mt-2"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 pr-0 pl-5 font-weight-normal pl-5 pt-2">印鑑</label>
                    <div class="text-center col-md-5">
                        <div class="d-flex justify-content-center align-items-center" id="div-input-image1">
                            <label for="btnEditInputUpload1" id="file-label-images1" class="file-label-images1 file-label-images" style="max-width: 100% !important;">クリックまたはドラッグしてファイルを指定</label>
                            <input type="file" id="btnEditInputUpload1" name="stamp" class="file-input-images1 file-input-images" accept="image/*" value="" image="1"
                                   style="width: 100% !important; cursor: pointer">
                        </div>
                        <div id="filePreviewEdit1" class="p-2 file-preview-area2 file-preview-area" >
                            <img class="img-upload-preview1 img-preview" src="" alt="preview uploaded file">
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
                    <div class="col-md-9 text-center">
                        <b class="text-danger">*</b><a class="" href="#"><input class="ml-1 mr-1" name="confirm" type="checkbox" disabled><u>利用規約に同意する</u></a>
                        <label for="confirm" class="error"></label>
                        <p class="text-danger error confirm mt-2"></p>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-3"></div>
                    <div class="col-lg-2 mt-4 mr-3 ml-3">
                        <center>
                            <button id="showConfirm" class="btn btn-primary btn-submit-code w-100" disabled>
                                登録
                            </button>
                        </center>
                    </div>
                    <div class="col-lg-1 col-sm-1"></div>
                    <div class="col-lg-2 mt-4 mr-3 ml-3">
                        <center>
                            <a id="btn-cancel" class="text-white btn btn-secondary exit-register-{{ request()->get('member') }} w-100">
                                キャンセル
                            </a>
                        </center>
                    </div>
                    <div class="col-lg-4 col-sm-4"></div>
                </div>
                <div class="message">
                    <ul class="list-group m-auto w-75 text-bottom">
                        <li class="list-group-item  border-0 bg-transparent">
                            ＊登録完了後に、ご登録のメールアドレスに登録確認のメールが送信されます。
                        </li>
                        <li class="list-group-item  border-0 bg-transparent">
                            メール受信後、メールのURLにアクセスして記載されている承認コードを入力して
                        </li>
                        <li class="list-group-item  border-0 bg-transparent">
                            任意のパスワードを設定して登録が完了となります。
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                    <button id="confirm-button" data-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary col-5">OK</button>
                    <button id="cancel" type="button" class="btn btn-secondary  col-5" data-dismiss="modal" aria-label="Close">
                        {{ __('message.register.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="successRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body modal-notification">
                    {{ __('message.register.success') }}
                </div>
                <div class="modal-footer">
                    <a href="#" class="url-certification btn btn-success">OK</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var checkZipCode = false;
        var key = '{{ config('constants.KEY_GEOCODING_API') }}';
        var messageRegisterSuccess = '{{ __('message.post_message.success') }}'
        var messageRequired = '{{ __('message.member.required') }}'
        var messageConfirmRequired = '{{ __('message.member.confirm_required') }}'
        var messageExit = '{{ __('message.post_message.exit') }}'
        var urlExit = "{{ route('get.owner.login') }}"
        $(document).ready(function() {
            if ($(window).width() <= 992) {
                $('input').focus(function () {
                    $('html, body').animate({
                        scrollTop: $(this).offset().top - 50
                    }, 'fast');
                });
            }
        });
    </script>
    <script src="{{ mix('/js/find_address.js') }}"></script>
    <script src="{{ mix('/js/register_member.js') }}"></script>
    <script src="{{ mix('/js/moment.min.js') }}"></script>
    <script src="{{ mix('/js/common/common-image-video-upload.js') }}"></script>
@endsection
