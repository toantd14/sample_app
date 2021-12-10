@extends('admin::layouts.master')

@section('title', '新しいスロットパーキングを作成する')

@section('css')
    <link rel="stylesheet" href="{{ mix('/css/admin/validate_register.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/slotParking.css') }}">
@endsection

@section('content')
    <div class="card-warning">
        <div class="card-body pl-0 pr-0">
            @if (session('success'))
                <div class="modal fade show" id="modalCreateSuccess" tabindex="-1" role="dialog" aria-modal="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6 class="modal-title">{{ session('success') }}</h6>
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="w-25 btn btn-primary m-auto">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('owner::slotsParking.modal_parking_exist')
            <div class="form-group row">
                <label class="col-4 col-md-2 font-weight-normal">管理区分<b class="text-danger">*</b></label>
                <div class="col-8 col-md-10 form-inline">
                    @if($parking->mgn_flg == App\Models\ParkingLot::MGN_FLG_ENABLE)
                        <label class="mr-3 ml-1">提携先</label>
                    @else
                        <label class="mr-3 ml-1">提携外</label>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-4 col-md-2 font-weight-normal">オーナー<b class="text-danger">*</b></label>
                <div class="col-8 col-md-10">
                    <label class="mr-3 ml-1">{{ $owner->name_c }}</label>
                </div>
            </div>
            <div class="box-add">
                <form id="from-create" method="POST" action="{{ route('parking-spaces.store') }}" role="form" class="form-slot-parking">
                    @csrf
                    <input type="hidden" name="parking_cd" value="{{ $parking->parking_cd }}">
                    <div class="form-group row">
                        <label class="col-4 col-md-2 font-weight-normal">駐車場形式 　<b class="text-danger">*</b></label>
                        <div class="col-8 col-md-10">
                            <select name="parking_form" class="form-control w-75">
                                <option value="">--選択して下さい--
                                </option>
                                <option value="0">平面駐車場(ロック式)</option>
                                <option value="1">平面駐車場(ロックレス式)
                                </option>
                                <option value="2">平面駐車場(ゲート式)</option>
                                <option value="3">機械式立体駐車場</option>
                                <option value="4">自走式立体駐車場</option>
                            </select>
                            @if ($errors->any() && $errors->has('parking_form'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('parking_form') }}</p>
                            @endif
                        </div>
                    </div>
                    {{old("car_type.kbn_standard")}}
                    <div class="form-group row">
                        <label class="col-4 col-md-2 font-weight-normal">車種　<b class="text-danger">*</b></label>
                        <div class="col-8 col-md-10">
                            <input type="checkbox" class="check-type"
                                   {{ old('car_type.kbn_standard') == 1 ? 'checked' : '' }} name="car_type[kbn_standard]" value="1"><label
                                class="mr-3 ml-1">普通</label>
                            <input type="checkbox" class="check-type"
                                   {{ old('car_type.kbn_3no') == 1 ? 'checked' : '' }} name="car_type[kbn_3no]" value="1"><label
                                class="mr-3 ml-1">３ナンバー</label>
                            <input type="checkbox" class="check-type"
                                   {{ old('car_type.kbn_lightcar') == 1 ? 'checked' : '' }} name="car_type[kbn_lightcar]" value="1"><label
                                class="mr-3 ml-1">軽自動車</label>
                            @if ($errors->any() && $errors->has('car_type'))
                                <p class="mb-0 parking-form error">{{ $errors->first('car_type') }}</p>
                            @endif
                            <label for="car_type[kbn_standard]" generated="false" class="error" hidden></label>
                            <label for="car_type[kbn_3no]" generated="false" class="error" hidden></label>
                            <label for="car_type[kbn_lightcar]" generated="false" class="error" hidden></label>
                            <p id="car_type_error" class="error"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-md-2 font-weight-normal">車幅 <b class="text-danger">*</b></label>
                        <div class="col-3 col-md-2">
                            <input type="number" value="{{ old('car_width') }}" name="car_width" class="form-control">
                            @if ($errors->any() && $errors->has('car_width'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('car_width') }}</p>
                            @endif
                        </div>
                        <label class="col-1 font-weight-normal text-center">m</label>
                        <div class="offset-md-2"></div>
                        <label class="col-2 col-md-2 font-weight-normal">車長 <b class="text-danger">*</b></label>
                        <div class="col-3 col-md-2">
                            <input type="number" name="car_length" value="{{ old('car_length') }}" class="form-control">
                            @if ($errors->any() && $errors->has('car_length'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('car_length') }}</p>
                            @endif
                        </div>
                        <label class="col-1 col-md-1 font-weight-normal text-center">m</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-md-2 font-weight-normal">車高 <b class="text-danger">*</b></label>
                        <div class="col-3 col-md-2">
                            <input type="number" name="car_height" value="{{ old('car_height') }}" class="form-control">
                            @if ($errors->any() && $errors->has('car_height'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('car_height') }}</p>
                            @endif
                        </div>
                        <label class="col-1 col-md-1 font-weight-normal text-center">m</label>
                        <div class="offset-md-2"></div>
                        <label class="col-2 col-md-2 font-weight-normal">車重 <b class="text-danger">*</b></label>
                        <div class="col-3 col-md-2">
                            <input type="number" name="car_weight" value="{{ old('car_weight') }}" class="form-control">
                            @if ($errors->any() && $errors->has('car_weight'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('car_weight') }}</p>
                            @endif
                        </div>
                        <label class="col-1 col-md-1 font-weight-normal text-center">t</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 font-weight-normal">記号 </label>
                        <div class="col-3 col-md-2">
                            <input type="text" name="space_symbol" value="{{ old('space_symbol') }}"
                                   class="form-control">
                            @if ($errors->any() && $errors->has('space_symbol'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('space_symbol') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 font-weight-normal">駐車番号 <b class="text-danger">*</b></label>
                        <div class="col-4 col-md-2">
                            <input type="number" name="space_no_from" value="{{ old('space_no_from') }}"
                                   class="form-control">
                            @if ($errors->any() && $errors->has('space_no_from'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('space_no_from') }}</p>
                            @endif
                        </div>
                        <label class="col-1 font-weight-normal text-center">~</label>
                        <div class="col-4 col-md-2">
                            <input type="number" name="space_no_to" value="{{ old('space_no_to') }}"
                                   class="form-control">
                            @if ($errors->any() && $errors->has('space_no_to'))
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('space_no_to') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-3 offset-lg-2 offset-sm-2"></div>
                        <button id="btn-submit" class="col-6 col-lg-3 col-sm-3 btn btn-primary mt-2">
                            登録
                        </button>
                        <div class="modal fade show" id="modalConfirm" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">駐車スペースの登録を実行します、よろしいですか？</h6>
                                        <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </a>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-confirm" type="submit" class="btn btn-primary" data-dismiss="modal" aria-label="Close">OK</button>
                                        <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">キャンセル</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offset-3 offset-lg-1 offset-sm-1"></div>
                        <div class="offset-3 offset-lg-1 offset-sm-1"></div>
                        <a link="{{ route('parkings.index') }}"
                           class="cancel text-white col-6 col-lg-3 col-sm-3 btn btn-secondary mt-2">
                           戻る
                        </a>
                        <div class="offset-3 offset-lg-2 offset-sm-2"></div>
                    </div>
                </form>
            </div>
            <div class="box-edit">
            </div>

            <div class="modal fade show" id="notification-update-completed" tabindex="-1" role="dialog" aria-modal="true" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h6 class="modal-title" id="content-notification"></h6>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="close-notification" class="w-25 btn btn-primary m-auto">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex mb-4">
                @if ($spaceParkings->currentPage() != 1)
                    <a href="{{ $spaceParkings->previousPageUrl() }}" class="ml-auto btn btn-primary mr-2"> < </a>
                @else
                    <span class="ml-auto btn btn-primary mr-2 disabled"> < </span>
                @endif
                @if ($spaceParkings->currentPage() != $spaceParkings->lastPage())
                    <a href="{{ $spaceParkings->nextPageUrl() }}" class="btn btn-primary"> > </a>
                @else
                    <span class="btn btn-primary disabled"> > </span>
                @endif
            </div>
            <div class="table col-12">
                <div class="row">
                    <div class="text-center cell col-2 col-lg-1">No</div>
                    <div class="text-center cell col-2 col-lg-1">記号</div>
                    <div class="text-center cell col-2 col-lg-1">番号</div>
                    <div class="text-center cell col-2 col-lg-1">普通</div>
                    <div class="text-center cell col-2 col-lg-1">３ナンバ</div>
                    <div class="text-center cell col-2 col-lg-1">軽自</div>
                    <div class="text-center cell col-2 col-lg-1">車幅</div>
                    <div class="text-center cell col-2 col-lg-1">車長</div>
                    <div class="text-center cell col-2 col-lg-1">車高</div>
                    <div class="text-center cell col-2 col-lg-1">車重</div>
                    <div class="text-center cell col-4 col-lg-2"></div>
                </div>
                @foreach($spaceParkings as $index => $slotParking)
                    <div class="row" id="slot-parking-serial-no-{{$slotParking->serial_no}}">
                        <input type="hidden" name="parking-cd" value="{{ $slotParking->serial_no }}">
                        <div class="cell text-center col-2 col-lg-1">{{ $index + $spaceParkings->firstItem() }}</div>
                        <div class="cell text-center col-2 col-lg-1 space_symbol">{{ $slotParking->space_symbol }}</div>
                        <div class="cell text-center col-2 col-lg-1 space_no">{{ $slotParking->space_no }}</div>
                        <div class="cell text-center col-2 col-lg-1 kbn_standard">
                            @if($slotParking->kbn_standard == 1)
                                <div class="dot"></div>
                            @endif
                        </div>
                        <div class="cell text-center col-2 col-lg-1 kbn_3no">
                            @if($slotParking->kbn_3no == 1)
                                <div class="dot"></div>
                            @endif
                        </div>
                        <div class="cell text-center col-2 col-lg-1 kbn_lightcar">
                            @if($slotParking->kbn_lightcar == 1)
                                <div class="dot"></div>
                            @endif
                        </div>
                        <div class="cell text-center col-2 col-lg-1 car_width">{{ $slotParking->car_width }}</div>
                        <div class="cell text-center col-2 col-lg-1 car_length">{{ $slotParking->car_length }}</div>
                        <div class="cell text-center col-2 col-lg-1 car_height">{{ $slotParking->car_height }}</div>
                        <div class="cell text-center col-2 col-lg-1 car_weight">{{ $slotParking->car_weight }}t</div>
                        <div class="cell text-center col-4 col-lg-2">
                            <button data-serial-no="{{ $slotParking->serial_no }}"
                                link="{{ route('parking-spaces.show', ['parking_space' => $slotParking->serial_no]) }}"
                                class="btn btn-primary edit-slot-parking">編集
                            </button>
                            <button class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $slotParking->serial_no }}">削除
                            </button>
                            <div class="modal fade" id="deleteModal{{ $slotParking->serial_no }}" tabindex="-1"
                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalLabel">
                                                選択した駐車スペースを削除します。よろしいですか？</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST"
                                                  action="{{ route('parking-spaces.destroy', ['parking_space' => $slotParking->serial_no ]) }}">
                                                <input name="_method" type="hidden" value="DELETE">
                                                @csrf
                                                <button type="submit" class="w-25 btn btn-primary">Ok</button>
                                                <a type="button" class="text-white btn btn-secondary"
                                                   data-dismiss="modal">キャンセル</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="slot-paginate" class="mt-4 text-center">
                {{ $spaceParkings->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('js')
    <script>
        $('select[name="parking_form"]').val("{{ old('parking_form') }}");
        let messConfirmExit = "{{ __('message.slot_parking.message_confirm_exit') }}";
        var messageRequired = "{{ __('message.message_required') }}";
        var messageSelected = "{{ __('message.slot_parking.message_select') }}";
        var messageNumberRequired = "{{ __('message.message_number_required') }}";
        $("#modalCreateSuccess").modal("show");
    </script>
    <script src="{{ mix('/js/admin/validate_slot_parking.js') }}"></script>
    <script src="{{ mix('/js/admin/create_slot_parking.js') }}"></script>
    <script src="{{ mix('/js/admin/jquery.validate.min.js') }}"></script>
    @if (session('parkingSpaceExist'))
        <script>
            $("#modalParkingExist").modal("show");
        </script>
    @endif
@endsection
