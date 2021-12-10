@extends('owner::layouts.master')
@section('title', '個人情報を編集する')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/validate_register.css') }}">
<link rel="stylesheet" href="{{ mix('/css/edit_user.css') }}">
@endsection
@section('content')
<div class="card-warning">
    <div class="card-body pl-0 pr-0">
        <form id="form-user-edit" action="{{ route('user.update', $user->user_cd) }}" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            @if(session('success'))
            @include('owner::layouts.modal_success')
            @endif
            @if (session()->has('editErrors'))
            <div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
            @endif
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal">区分 <b class="text-danger">*</b></label>
                <div class="col-md-10 col-8 pl-0">
                    @if ($user->user_kbn == \App\Models\Owner::PERSONAL)
                    <input class="role" type="radio" name="kubun" value="0" checked><label class="mr-3 ml-1">個人</label>
                    <input class="role" id="company" name="kubun" value="1" type="radio"><label class="mr-3 ml-1">法人</label>
                    @else
                    <input class="role" type="radio" name="kubun" value="0"><label class="mr-3 ml-1">個人</label>
                    <input class="role" type="radio" id="company" name="kubun" value="1" checked><label class="mr-3 ml-1">法人</label>
                    @endif
                    <p class="text-danger error kubun mt-2"></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal">SNSアカウント連携</label>
                <div class="col-md-3 col-8 pl-0">
                    @switch($user)
                    @case($user->facebook_id != null)
                    <span>{{ config("constants.SNS.FACEBOOK") }}</span>
                    @break
                    @case($user->google_id != null)
                    <span>{{ config("constants.SNS.GOOGLE") }}</span>
                    @break
                    @case($user->line_id != null)
                    <span>{{ config("constants.SNS.LINE") }}</span>
                    @break
                    @endswitch
                </div>
            </div>
            <div id="user-name">
                <div class="form-group row">
                    <label class="col-md-2 col-4 font-weight-normal pt-2">お名前 <b class="text-danger">*</b></label>
                    <div class="col-md-3 col-8 pl-0">
                        <input type="text" name="name_c[0]" class="form-control" value="{{ old('name_c[0]') ?? $user->name_sei }}" placeholder="（姓）">
                        <p class="text-danger error name_c mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-3 col-8 pl-0">
                        <input type="text" name="name_c[1]" class="form-control" value="{{ old('name_c[1]') ?? $user->name_mei }}" placeholder="（名）">
                        <p class="text-danger error name_c mt-2"></p>
                    </div>
                </div>
            </div>
            <div id="user-company">
                <div class="form-group row">
                    <label class="col-md-2 col-4 font-weight-normal  pt-2">ご契約名 <b class="text-danger">*</b></label>
                    <div class="col-md-6 col-8 pl-0">
                        <input type="text" name="name_c[2]" value="{{ old('name_c[2]') ?? $user->corporate_name }}" class="form-control">
                        <p class="text-danger error name_c mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-4 col-8 pl-0 pt-2">
                        （法人の場合、法人名を入力して下さい）
                    </div>
                </div>
            </div>
            <div id="info-company">
                <div class="form-group row">
                    <label class="col-md-2 col-4 font-weight-normal pt-2">担当者名 <b class="text-danger">*</b></label>
                    <div class="col-md-4 col-8 pl-0">
                        <input type="text" name="person_man" value="{{ old('person_man') ?? $user->person_man }}" class="form-control">
                        <p class="text-danger error name_c mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-6 col-8 pl-0 pt-2">
                        （法人の連絡ご担当者名を入力して下さい）
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-4 font-weight-normal pt-2">部署名</label>
                    <div class="col-md-5 col-8 pl-0">
                        <input type="text" name="department" value="{{ old('department') ?? $user->department }}" class="form-control">
                        <p class="text-danger error department mt-2"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-4 font-weight-normal pt-2">法人HP-URL</label>
                    <div class="col-md-6 col-8 pl-0">
                        <input type="text" name="hp_url" value="{{ old('hp_url') ?? $user->hp_url }}" class="form-control">
                        <p class="text-danger error hp_url mt-2"></p>
                    </div>
                    <div class="div-hident col-4"></div>
                    <div class="col-md-4 col-8 pl-0 pt-2">
                        （ホームページのURLを入力して下さい）
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal pt-2">メールアドレス <b class="text-danger">*</b></label>
                <div class="col-md-6 col-8 pl-0">
                    <input type="hidden" name="user_cd" value="{{ $user->user_cd }}">
                    <input type="hidden" name="facebook_id" value="{{ $user->facebook_id }}">
                    <input type="hidden" name="google_id" value="{{ $user->google_id }}">
                    <input type="hidden" name="line_id" value="{{ $user->line_id }}">
                    <input type="text" name="mail_add" value="{{ old('mail_add') ?? $user->mail_add }}" class="form-control" @if(!($user->facebook_id || $user->google_id || $user->line_id))
                    readonly
                    @endif
                    >
                    <p class="text-danger error mail_add mt-2"></p>
                </div>
                <div class="div-hident col-4"></div>
                <div class="col-md-4 col-8 pt-2 pl-0">
                    （ログインIDとなります。）
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal pt-2">住所 <b class="text-danger">*</b><span class="float-right">〒</span></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="zip_cd" value="{{ old('zip_cd') ?? $user->zip_cd }}" class="form-control zip_code" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                    <p class="text-danger error zip_cd mt-2"></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 pt-2"><span class="float-right pr-1"><b class="text-danger">*</b></span></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="prefectures" value="{{ old('prefectures') ?? $prefecture->prefectures_name }}" class="form-control prefectures">
                    <p class="text-danger error prefectures mt-2"></p>
                </div>
                <div class="div-hident col-4"></div>
                <div class="col-md-5 col-8 pt-2 pl-0">
                    （都道府県）
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 pt-2"><span class="float-right pr-1"><b class="text-danger">*</b></span></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="municipality_name" value="{{ old('municipality_name') ?? $user->municipality_name }}" class="form-control municipality_name">
                    <p class="text-danger error municipality_name mt-2"></p>
                </div>
                <div class="div-hident col-4"></div>
                <div class="col-md-5 col-8 pt-2 pl-0">
                    （市区町村郡）
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 pt-2"><span class="float-right pr-1"><b class="text-danger">*</b></span></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="townname_address" value="{{ old('townname_address') ?? $user->townname_address }}" class="form-control townname_address">
                    <p class="text-danger error townname_address mt-2"></p>
                </div>
                <div class="div-hident col-4"></div>
                <div class="col-md-5 col-8 pt-2 pl-0">
                    （町域名＋番地）
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4"></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="building_name" value="{{ old('building_name') ?? $user->building_name }}" class="form-control">
                    <p class="text-danger error building_name mt-2"></p>
                </div>
                <div class="div-hident col-4"></div>
                <div class="col-md-5 col-8 pl-0 pt-2">
                    （建物等）
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal pt-2">電話番号 <b class="text-danger">*</b></label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="tel_no" value="{{ old('tel_no') ?? $user->tel_no }}" class="form-control">
                    <p class="text-danger error tel_no mt-2"></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-4 font-weight-normal pt-2">FAX番号</label>
                <div class="col-md-5 col-8 pl-0">
                    <input type="text" name="fax_no" value="{{ old('fax_no') ?? $user->fax_no }}" class="form-control">
                    <p class="text-danger error fax_no mt-2"></p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 col-lg-3"></div>
                <div class="col-lg-2 mt-4 mr-3 ml-3">
                    <center>
                        <button type="submit" class="user-edit-btn-submit btn btn-primary btn-submit-code w-100">
                            更新
                        </button>
                    </center>
                </div>
                <div class="col-md-1 col-lg-1"></div>
                <div class="col-lg-2 mt-4 mr-3 ml-3">
                    <center>
                    <a href="javascript:void(0)" class="user-edit-btn-cancel btn btn-secondary w-100" data-toggle="modal" data-target="#modalCancel">キャンセル</a>
                    </center>
                </div>
                <div class="col-md-4 col-lg-4"></div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
@include('owner::layouts.modal_confirm')
<div class="modal fade show" id="modalCancel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">修正をキャンセルします。よろしいですか？</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-cancle">OK</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var key = "{{ config('constants.KEY_GEOCODING_API') }}";
    var messageRegisterSuccess = "{{ __('message.post_message.success') }}"
    var messageRequired = "{{ __('message.member.required') }}"
    var messageExit = "{{ __('message.post_message.exit') }}"
    var messageExit = "{{ __('message.post_message.exit') }}"
    var checkZipCode = true;
    var messageConfirmRequired = "{{ __('message.member.confirm_required') }}"
    $('input').focus(function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 50
        }, 'fast');
    });
    var authorization = "{{ request()->headers->get('Authorization') }}";
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
</script>
<script src="{{ mix('/js/find_address.js') }}"></script>
<script src="{{ mix('/js/register_member.js') }}"></script>
<script src="{{ mix('/js/edit_user.js') }}"></script>
@endsection
