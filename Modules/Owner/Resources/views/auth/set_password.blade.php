@extends('owner::layouts.master')

@section('title', '認証コード入力＋パスワード設定')

@section('content')
<div class="set-password">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-12 col-12 col-lg-10">
            <p class="alert alert-danger d-none"></p>
            <form method="post" action="{{ route('member.do.set.password') }}" class="form-horizontal form-set-password">
                @csrf
                <div class="card-body px-0">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label pl-xl-5">認証コード <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="certification_cd" class="form-control">
                        </div>
                        <div class="col-md-5 pt-2">
                            （受信メールに記載のコードを入力）
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label pl-xl-5">パスワード <span class="text-danger">*</span></label>
                        <div class="col-md-5">
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-5 pt-2">
                            （半角英数、記号の混在する6文字以上）
                        </div>
                    </div>
                    <input type="hidden" name="member_cd" value="{{ request()->get('member_cd') }}">
                    <input type="hidden" name="member" value="{{ request()->get('member') }}">
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="">
                            <button type="button" class="btn border-dark btn-secondary submit-set-password">登録</button>
                            <a href="#" data-toggle="modal" data-target="#modalCancel" class="btn border-dark mx-3 btn-secondary">キャンセル</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
                <button type="button" class="btn-modal-cancel text-white btn btn-primary">OK</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            </div>
        </div>
    </div>
</div>
@include('owner::layouts.modal_success')
@endsection

@section('js')
<script>
    var messageRegisterSuccess = "{{ __('message.post_message.success') }}"
    var messageRequired = "{{ __('message.member.required') }}"
    var messageExit = "{{ __('message.post_message.exit') }}"
    var memberUser = "{{ config('owner.role_user') }}"
    var urlExit = "{{ route('get.owner.login') }}"
</script>
<script src="{{ mix('/js/auth.js') }}"></script>
@endsection
