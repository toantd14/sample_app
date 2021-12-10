@extends('owner::layouts.master')

@section('title', '駐車スペース編集')

@section('css')
    <link rel="stylesheet" href="{{ mix('/css/slotParking.css') }}">
@endsection

@section('content')
    <div class="card-warning">
        <div class="card-body">
            <form role="form">
                <!-- text input -->
                <div class="form-group row">
                    <label class="col-4 col-md-2 font-weight-normal">駐車場形式 　<b class="text-danger">*</b></label>
                    <div class="col-8 col-md-10">
                        <select class="form-control w-75">
                            <option>--選択して下さい--</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-md-2 font-weight-normal">車種　<b class="text-danger">*</b></label>
                    <div class="col-8 col-md-10">
                        <input type="radio" name="male" checked><label class="mr-3 ml-1">普通</label>
                        <input type="radio" name="male"><label class="mr-3 ml-1">３ナンバー</label>
                        <input type="radio" name="male"><label class="mr-3 ml-1">軽自動車</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-md-2 font-weight-normal">車幅 <b class="text-danger">*</b></label>
                    <div class="col-3 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                    <label class="col-1 font-weight-normal text-center">m</label>
                    <div class="offset-md-2"></div>
                    <label class="col-2 col-md-2 font-weight-normal">車長 <b class="text-danger">*</b></label>
                    <div class="col-3 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                    <label class="col-1 col-md-1 font-weight-normal text-center">m</label>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-md-2 font-weight-normal">車高 <b class="text-danger">*</b></label>
                    <div class="col-3 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                    <label class="col-1 col-md-1 font-weight-normal text-center">m</label>
                    <div class="offset-md-2"></div>
                    <label class="col-2 col-md-2 font-weight-normal">車重 <b class="text-danger">*</b></label>
                    <div class="col-3 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                    <label class="col-1 col-md-1 font-weight-normal text-center">t</label>
                </div>
                <div class="form-group row">
                    <label class="col-2 font-weight-normal">記号 </label>
                    <div class="col-3 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 font-weight-normal">駐車番号 <b class="text-danger">*</b></label>
                    <div class="col-4 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                    <label class="col-1 font-weight-normal text-center">~</label>
                    <div class="col-4 col-md-2">
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-3 offset-sm-2"></div>
                    <button class="btn btn-primary col-6 col-sm-3 mt-2">
                        登録
                    </button>
                    <div class="offset-3 offset-sm-1"></div>
                    <div class="offset-3 offset-sm-1"></div>
                    <button class="btn btn-secondary col-6 col-sm-3 mt-2">
                        キャンセル
                    </button>
                    <div class="offset-3 offset-sm-2"></div>
                </div>
            </form>

            <div class="mt-4 d-flex mb-4">
                <a href="#" class="btn btn-primary ml-auto mr-2"> < </a>
                <a href="#" class="btn btn-primary"> > </a>
            </div>
            <div class="table">
                <div class="row text-center">
                    <div class="cell col-2 col-lg-1">No</div>
                    <div class="cell col-2 col-lg-1">記号</div>
                    <div class="cell col-2 col-lg-1">番号</div>
                    <div class="cell col-2 col-lg-1">普通</div>
                    <div class="cell col-2 col-lg-1">３ナンバ</div>
                    <div class="cell col-2 col-lg-1">軽自</div>
                    <div class="cell col-2 col-lg-1">車幅</div>
                    <div class="cell col-2 col-lg-1">車長</div>
                    <div class="cell col-2 col-lg-1">車高</div>
                    <div class="cell col-2 col-lg-1">車重</div>
                    <div class="cell col-4 col-lg-2"></div>
                </div>
                <div class="row">
                    <div class="cell text-center col-2 col-lg-1">1</div>
                    <div class="cell text-center col-2 col-lg-1">A</div>
                    <div class="cell text-center col-2 col-lg-1">10</div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">5.0</div>
                    <div class="cell text-center col-2 col-lg-1">1.2t</div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-primary">編集</button></div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-danger">削除</button></div>
                </div>
                <div class="row">
                    <div class="cell text-center col-2 col-lg-1">1</div>
                    <div class="cell text-center col-2 col-lg-1">A</div>
                    <div class="cell text-center col-2 col-lg-1">10</div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">5.0</div>
                    <div class="cell text-center col-2 col-lg-1">1.2t</div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-primary">編集</button></div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-danger">削除</button></div>
                </div>
                <div class="row">
                    <div class="cell text-center col-2 col-lg-1">1</div>
                    <div class="cell text-center col-2 col-lg-1">A</div>
                    <div class="cell text-center col-2 col-lg-1">10</div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1"><div class="dot"></div></div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">2.0</div>
                    <div class="cell text-center col-2 col-lg-1">5.0</div>
                    <div class="cell text-center col-2 col-lg-1">1.2t</div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-primary">編集</button></div>
                    <div class="cell text-center col-2 col-lg-1"><button class="btn btn-danger">削除</button></div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
