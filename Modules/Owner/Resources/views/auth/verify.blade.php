@extends('owner::layouts.master')

@section('title', 'ヘッダ')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/confirmPassword.css') }}">
@endsection

@section('content')
    <div class="card-info content">
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">認証コード <span class="required">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="inputEmail3">
                        </div>
                        <div class="col-sm-4">
                            <p class="note">(受信メールに記載のコードを入力)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">パスワード <span class="required">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword3">
                        </div>
                        <div class="col-sm-4">
                            <p class="note">(半角英数、記号の混在する6文字以上)</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-info">登録</button>
                            <button type="submit" class="btn btn-default">キャンセル</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
@endsection
