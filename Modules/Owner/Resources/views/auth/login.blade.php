@extends('owner::layouts.master')
@section('title', 'ログイン')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/login.css') }}">
@endsection
@section('content')
    <div class="login">
        <div class="row justify-content-center mt-5">
            <div class="col-sm-12 col-12 col-md-8 col-lg-5">
                @if ($errors->any())
                    <p class="alert alert-danger">
                        {{ $errors->first() }}
                    </p>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <form method="post" action="{{ route('do.owner.login', ['member' => request()->member ?? '']) }}" class="form-horizontal">
                    @csrf
                    <div class="card-body px-0">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">ログインID</label>
                            <div class="col-sm-9">
                                <input value="{{ old('id') }}" name="id" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">パスワード</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn border-dark btn-secondary">ログイン</button>
                        <a href="#" class="btn border-dark mx-3 btn-secondary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-sm-12 col-12 col-md-8 col-lg-8">
                <div class="row mt-2 mx-0 justify-content-center">
                    <span>未登録の方は、こちらからご登録いただくことでご利用が可能です。</span>
                </div>
                <div class="row mt-1 justify-content-center">
                    <a href="{{ route('member.get.register') }}" class="btn btn-primary p-2 px-3 register">新規ご登録</a>
                </div>
            </div>
        </div>
    </div>
@endsection
