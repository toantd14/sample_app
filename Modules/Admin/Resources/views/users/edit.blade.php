@php
    use App\Models\MstUser;
@endphp
@extends('admin::layouts.master')
@section('title', '個人情報を編集する')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/admin/validate_register.css') }}">
@endsection
@section('content')
    <div class="card-warning">
        <div class="card-body">
            <form id="form-user-edit" action="{{ route('post.users.edit', $user->user_cd) }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                @if (session()->has('editErrors'))
                    <div class="alert alert-danger">{{ session()->get('editErrors') }}</div>
                @endif
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">利用者区分　<b class="text-danger">*</b></label>
                    <div class="col-md-10">
                        @if ($user->user_kbn == MstUser::PERSONAL)
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
                    <label class="col-md-2 font-weight-normal">利用方法<br>{{ MstUser::TYPE_LOGIN[$user->howto_use] }}</label>
                    <div class="col-md-3">
                        <span class="form-text">
                            {{ $user->uniqueUserID() }}
                        </span>
                    </div>
                </div>
                <div id="user-name">
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">お名前 <b class="text-danger">*</b></label>
                        <div class="col-md-3">
                            <input type="text" name="name_c[0]" class="form-control" value="{{ old('name_c[0]') ?? $user->name_sei }}" placeholder="（姓）">
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="name_c[1]" class="form-control" value="{{ old('name_c[1]') ?? $user->name_mei }}" placeholder="（名）">
                            <p class="text-danger error name_c mt-2"></p>
                        </div>
                    </div>
                </div>
                <div id="info-company">
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">法人名
                            <b class="text-danger">*</b></label>
                        <div class="col-md-5">
                            <input type="text" name="corporate_name" value="{{ old('corporate_name') ?? $user->corporate_name }}" class="form-control">
                            <p class="text-danger error corporate_name mt-2"></p>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">
                            担当部署 <b class="text-danger"></b></label>
                        <div class="col-md-5">
                            <input type="text" name="department" value="{{ old('department') ?? $user->department }}" class="form-control">
                            <p class="text-danger error department mt-2"></p>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </div>
                <div class="box-border-top border pt-1 pl-1 mb-3">
                    <div class="form-group row">
                        <label class="col-md-2 font-weight-normal">住所 <b class="text-danger">*</b><span class="float-right">〒</span></label>
                        <div class="col-md-3">
                            <input type="text" name="zip_cd" value="{{ old('zip_cd') ?? $user->zip_cd }}" class="form-control zip_code" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                            <p class="text-danger error zip_cd mt-2"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2"></label>
                        <div class="col-md-3">
                            <input type="text" name="prefectures" placeholder="（都道府県）" value="{{ old('prefectures') ?? $prefecture->prefectures_name }}" class="form-control prefectures">
                            <p class="text-danger error prefectures mt-2"></p>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2"></label>
                        <div class="col-md-5">
                            <input type="text" name="municipality_name" placeholder="（市区町村郡）" value="{{ old('municipality_name') ?? $user->municipality_name }}" class="form-control municipality_name">
                            <p class="text-danger error municipality_name mt-2"></p>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2"></label>
                        <div class="col-md-5">
                            <input type="text" name="townname_address" placeholder="（町域名＋番地）" value="{{ old('townname_address') ?? $user->townname_address }}" class="form-control townname_address">
                            <p class="text-danger error townname_address mt-2"></p>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2"></label>
                        <div class="col-md-5">
                            <input type="text" name="building_name" placeholder="（建物等）" value="{{ old('building_name') ?? $user->building_name }}" class="form-control">
                            <p class="text-danger error building_name mt-2"></p>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">電話番号 <b class="text-danger">*</b></label>
                    <div class="col-md-5">
                        <input type="text" name="tel_no" placeholder="ハイフン無しで入力" value="{{ old('tel_no') ?? $user->tel_no }}" class="form-control">
                        <p class="text-danger error tel_no mt-2"></p>
                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 font-weight-normal">メールアドレス <b class="text-danger">*</b></label>
                    <div class="col-md-5">
                        <input type="hidden" name="user_cd" value="{{ $user->user_cd }}">
                        <input type="hidden" name="facebook_id" value="{{ $user->facebook_id }}">
                        <input type="hidden" name="google_id" value="{{ $user->google_id }}">
                        <input type="hidden" name="line_id" value="{{ $user->line_id }}">
                        <input type="text" name="mail_add" value="{{ old('mail_add') ?? $user->mail_add }}" class="form-control"
                        @if(!($user->facebook_id || $user->google_id || $user->line_id))
                        readonly
                        @endif
                        >
                        <p class="text-danger error mail_add mt-2"></p>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 col-lg-3"></div>
                    <button class="col-md-2 col-lg-2 btn btn-primary mb-4">
                        更新
                    </button>
                    <div class="col-md-1 col-lg-1"></div>
                    <a href="javascript:void(0)" class="col-md-2 col-lg-2 btn btn-secondary mb-4" data-toggle="modal" data-target="#modalCancel">キャンセル</a>
                    <div class="col-md-4 col-lg-4"></div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    @include('admin::layouts.modal_confirm')
    @include('admin::layouts.modal_success')
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
                    <button type="button" class="btn btn-primary btn-cancel">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var messageRequired = "{{ __('message.member.required') }}"
        var authorization = "{{ request()->headers->get('Authorization') }}"
        var urlUsersList = "{{ route('users.list')}}"
        var checkZipCode = true;
    </script>
    <script src="{{ mix('/js/admin/find_address.js') }}"></script>
    <script src="{{ mix('/js/admin/edit_user.js') }}"></script>
@endsection
