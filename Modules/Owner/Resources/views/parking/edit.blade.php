@extends('owner::layouts.master')
@section('title', '駐車場一覧')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/register-parking.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/parkingtimepicker.css') }}">
@endsection
@section('content')
    <div class="register-parking pt-3">
        <div class="alert alert-danger errors">
            <span></span>
        </div>
        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session()->get('error') }}</div>
        @endif
        <form method="POST" action="{{ route('parkinglot.update',  $parkingLot->parking_cd) }}" class="form-register form-check-code"
              enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="form-group d-flex pl-1">
                <label class="w-15 w-xs-25 pl-5 pt-2 font-weight-normal">名称<b class="text-danger">*</b></label>
                @if ($errors->any() && $errors->has('name'))
                    <div class="w-45 w-xs-75">
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control bg-danger">
                        <p class="mb-0 text-danger parking-form error">{{ $errors->first('name') }}</p>
                    </div>
                @else
                    <div class="w-45 w-xs-75">
                        <input type="text" value="{{ old('name') ?? $parkingLot->parking_name }}" name="name"
                               class="form-control">
                    </div>
                @endif
            </div>
            <div class="box-border-top border pt-1 pl-1">
                <div class="form-group d-flex flex-wrap">
                    <label class="w-15 w-xs-25 pl-5 pt-2 font-weight-normal pr-1">住所 <b class="text-danger mr-2">*</b><span
                            class="float-right">〒</span></label>
                    @if($errors->any() && $errors->has('code'))
                        <div class="w-45 w-xs-75">
                            <input type="text" value="{{ old('code') }}" name="code" class="form-control bg-danger zip_code" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('code') }}</p>
                        </div>
                    @else
                        <div class="w-25 w-xs-100">
                            <input type="text" value="{{ old('code') ?? $parkingLot->zip_cd }}" name="code"
                                   class="form-control zip_code" placeholder="{{ config('constants.ZIPCOD_PLACEHOLDER') }}">
                        </div>
                    @endif
                </div>
                <div class="form-group d-flex flex-wrap">
                    <label class="w-15 w-xs-25 pt-2 "><b class="text-danger float-right mr-2">*</b></label>
                    @if($errors->any() && $errors->has('prefectures'))
                        <div class="w-45 w-xs-75">
                            <input type="text" value="{{ old('prefectures') }}" name="prefectures"
                                   class="form-control bg-danger prefectures">
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('prefectures') }}</p>
                        </div>
                    @else
                        <div class="w-25 w-xs-50">
                            <input type="text" value="{{ old('prefectures') ?? $prefectures_name }}"
                                   name="prefectures"
                                   class="form-control prefectures">
                        </div>
                    @endif
                    <label class="w-xs-100 pt-2 font-weight-normal ml-xs-25">
                        （都道府県）
                    </label>
                </div>
                <div class="form-group d-flex flex-wrap">
                    <label class="w-xs-25 w-15 pt-2"><b class="text-danger float-right mr-2">*</b></label>
                    @if($errors->any() && $errors->has('municipality'))
                        <div class="w-45 w-xs-75">
                            <input type="text" value="{{ old('municipality') }}" name="municipality"
                                   class="form-control bg-danger municipality_name">
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('municipality') }}</p>
                        </div>
                    @else
                        <div class="w-25 w-xs-50">
                            <input type="text" value="{{ old('municipality') ?? $parkingLot->municipality_name }}"
                                   name="municipality"
                                   class="form-control municipality_name">
                        </div>
                    @endif
                    <label class="w-xs-100 pt-2 font-weight-normal ml-xs-25">
                        （市区町村郡）
                    </label>
                </div>
                <div class="form-group d-flex flex-wrap">
                    <label class="w-xs-25 w-15 pt-2 "><b class="text-danger float-right mr-2">*</b></label>
                    @if($errors->any() && $errors->has('town_area'))
                        <div class="w-45 w-xs-75">
                            <input type="text" value="{{ old('town_area') }}" name="town_area"
                                   class="form-control bg-danger townname_address">
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('town_area') }}</p>
                        </div>
                    @else
                        <div class="w-25 w-xs-50">
                            <input type="text" value="{{ old('town_area') ?? $parkingLot->townname_address }}"
                                   name="town_area"
                                   class="form-control townname_address">
                        </div>
                    @endif
                    <label class="pt-2 font-weight-normal text-center ml-xs-25">
                        （町域名＋番地）
                    </label>
                </div>
                <div class="form-group d-flex flex-wrap">
                    <label class="w-xs-25 w-15 pt-2"></label>
                    <div class="w-25 w-xs-50">
                        <input type="text"
                               value="{{ old('building_name') ?? $parkingLot->building_name }}"
                               name="building_name" class="form-control">
                    </div>
                    <label class="pt-2 font-weight-normal ml-xs-25">
                        （建物等）
                    </label>
                </div>
            </div>

            <div class="box-border-bottom border border-top-0 pt-1 pl-1">
                <div class="d-flex flex-wrap ">
                    <div class="w-60 w-xs-100">
                        <div class="form-group d-flex">
                            <label for="latitude" class="w-xs-25 pl-5 w-25 pt-2 font-weight-normal">緯度<b
                                    class="text-danger">*</b></label>
                            @if($errors->any() && $errors->has('latitude'))
                                <div class="w-45 w-xs-75">
                                    <input type="text" value="{{ old('latitude') }}" name="latitude"
                                           class="form-control bg-danger">
                                    <p class="mb-0 text-danger parking-form error">{{ $errors->first('latitude') }}</p>
                                </div>
                            @else
                                <div class="w-75">
                                    <input id="latitude" value="{{ old('latitude') ?? $parkingLot->latitude }}"
                                           name="latitude" type="text"
                                           class="form-control">
                                </div>
                            @endif
                        </div>
                        <div class="form-group d-flex">
                            <label for="longtitude" class="w-xs-25 pl-5 w-25 pt-2 font-weight-normal">経度<b
                                    class="text-danger">*</b></label>
                            @if($errors->any() && $errors->has('longitude'))
                                <div class="w-45 w-xs-75">
                                    <input type="text" value="{{ old('longitude') }}" name="longitude"
                                           class="form-control bg-danger">
                                    <p class="mb-0 text-danger parking-form error">{{ $errors->first('longitude') }}</p>
                                </div>
                            @else
                                <div class="w-75">
                                    <input id="longitude" value="{{ old('longitude') ?? $parkingLot->longitude }}"
                                           name="longitude"
                                           type="text"
                                           class="form-control">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="w-40 m-auto text-center ml-xs-25 text-xs-center-0">
                        <button type="button" class="btn btn-secondary p-4 p-xs-5 mb-xs-4 px-xs-3 search-gps">
                            GPS座標検索
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group d-flex pl-1 mt-1">
                <label class="w-xs-25 pl-5 w-15 pt-2 font-weight-normal">電話番号<b
                        class="text-danger">*</b></label>
                @if($errors->any() && $errors->has('tel_no'))
                    <div class="w-15 w-xs-25">
                        <input type="text" value="{{ old('tel_no') }}" placeholder="ハイフン無しで入力" name="tel_no" class="form-control bg-danger">
                        <p class="mb-0 text-danger parking-form error">{{ $errors->first('tel_no') }}</p>
                    </div>
                @else
                    <div>
                        <input type="text" value="{{ old('tel_no') ?? $parkingLot->tel_no }}" placeholder="ハイフン無しで入力" name="tel_no"
                               class="form-control">
                    </div>
                @endif
                <div>
                </div>
            </div>
            <div class="form-group d-flex pl-1">
                <label class="w-xs-25 pl-5 w-15 pt-2 font-weight-normal">FAX番号</label>
                @if($errors->any() && $errors->has('fax_no'))
                    <div class="w-15 w-xs-25">
                        <input name="fax_no" value="{{ old('fax_no') ? old('fax_no') : $parkingLot->fax_no }}"
                               type="text"
                               class="form-control bg-danger">
                        <p class="mb-0 text-danger parking-form error">{{ $errors->first('tel_no') }}</p>
                    </div>
                @else
                    <div class="w-15 w-xs-25">
                        <input name="fax_no" value="{{ old('fax_no') ?? $parkingLot->fax_no }}" type="text"
                               class="form-control">
                    </div>
                @endif
            </div>
            <div class="form-group d-flex flex-wrap pl-1">
                <label class="w-xs-25 w-15 pt-2 pl-5 font-weight-normal">営業時間<b
                        class="text-danger float-right mr-2">*</b></label>
                @if($errors->any() && $errors->has('sales_start_time'))
                    <div class="w-15 w-xs-25">
                        <div class="form-group">
                            <div class="input-group date input-group-append" id="sales_start_time"
                                 data-target-input="nearest">
                                <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                       class="timepicker form-control bg-danger"
                                       name="sales_start_time" value="{{ old('sales_start_time') }}"
                                />
                            </div>
                        </div>
                        <p class="mb-0 text-danger parking-form error">{{ $errors->first('sales_start_time') }}</p>
                    </div>
                @else
                    <div class="w-15 w-xs-25">
                        <div class="form-group">
                            <div class="input-group date input-group-append" id="sales_start_time"
                                 data-target-input="nearest">
                                <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                       class="timepicker form-control"
                                       name="sales_start_time"
                                       value="{{ old('sales_start_time') ?? $parkingLot->sales_start_time }}"
                                />
                            </div>
                        </div>
                    </div>
                @endif
                <div class="w-15 w-xs-25 text-center">
                    <b>~</b>
                </div>
                @if($errors->any() && $errors->has('sales_end_time'))
                    <div class="w-15 w-xs-25">
                        <div class="form-group">
                            <div class="input-group date input-group-append" id="sales_end_time"
                                 data-target-input="nearest">
                                <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                       class="timepicker form-control bg-danger"
                                       name="sales_end_time" value="{{ old('sales_end_time') }}"
                                />
                            </div>
                        </div>
                        <p class="mb-0 text-danger parking-form error">{{ $errors->first('sales_end_time') }}</p>
                    </div>
                @else
                    <div class="w-15 w-xs-25">
                        <div class="form-group">
                            <div class="input-group date input-group-append" id="sales_end_time"
                                 data-target-input="nearest">
                                <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                       class="timepicker form-control"
                                       name="sales_end_time"
                                       value="{{ old('sales_end_time') ?? $parkingLot->sales_end_time }}"
                                />
                            </div>
                        </div>
                    </div>
                @endif
                <div class="w-15 w-xs-100 ml-2 pt-2 ">
                    <input type="checkbox" name="sales_division"
                        @if((!(old('sales_start_time') || old('sales_end_time'))
                        && $parkingLot->sales_division == App\Models\ParkingLot::SALES_DIVISION_ENABLE) || old('sales_division'))
                            {{ 'checked' }}
                        @endif
                    class="ml-xs-25">
                    <lable class="font-weight-normal">24時間営業</lable>
                </div>
            </div>
            <div class="form-group d-flex flex-wrap pl-1">
                <div class="w-60 w-xs-100 ">
                    <div class="form-group d-flex flex-wrap">
                        <div class="w-25 w-xs-25">
                        </div>
                        <label class="pt-2 pl-5 w-25 font-weight-normal">入庫<b class="text-danger">*</b></label>
                        <div class="w-25 text-center"></div>
                        @if($errors->any() && $errors->has('lu_start_time'))
                            <div class="w-25 w-xs-45">
                                <div class="form-group">
                                    <div class="input-group date input-group-append" id="lu_start_time"
                                         data-target-input="nearest">
                                        <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                               class="timepicker form-control bg-danger"
                                               name="lu_start_time" value="{{ old('lu_start_time') }}"
                                        />
                                    </div>
                                </div>
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('lu_start_time') }}</p>
                            </div>
                        @else
                            <div class="w-25 w-xs-45">
                                <div class="form-group">
                                    <div class="input-group date input-group-append" id="lu_start_time"
                                         data-target-input="nearest">
                                        <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                               class="timepicker form-control"
                                               name="lu_start_time"
                                               value="{{ old('lu_start_time') ?? $parkingLot->lu_start_time }}"
                                        />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group d-flex flex-wrap">
                        <div class="w-25 w-xs-25">
                        </div>
                        <label class="pt-2 w-25 pl-5 font-weight-normal">出庫<b class="text-danger">*</b></label>
                        <div class="w-25 text-center"></div>
                        @if($errors->any() && $errors->has('lu_end_time'))
                            <div class="w-25 w-xs-45">
                                <div class="form-group">
                                    <div class="input-group date input-group-append" id="lu_end_time"
                                         data-target-input="nearest">
                                        <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                               class="timepicker form-control bg-danger"
                                               name="lu_end_time" value="{{ old('lu_end_time') }}"
                                        />
                                    </div>
                                </div>
                                <p class="mb-0 text-danger parking-form error">{{ $errors->first('lu_end_time') }}</p>
                            </div>
                        @else
                            <div class="w-25 w-xs-45">
                                <div class="form-group">
                                    <div class="input-group date input-group-append" id="lu_end_time"
                                         data-target-input="nearest">
                                        <input type="text" placeholder="{{ config('constants.TIME.INPUT_PLACEHOLDER_FORMAT') }}" autocomplete="off"
                                               class="timepicker form-control"
                                               name="lu_end_time"
                                               value="{{ old('lu_end_time') ?? $parkingLot->lu_end_time }}"
                                        />
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="w-25 w-xs-25"></div>
                        @if (session('errorLutime'))
                            <p class="mb-0 text-danger parking-form error">{{ session('errorLutime') }}</p>
                        @endif
                    </div>
                </div>
                <div class="w-40 w-xs-100">
                    <div class="ml-2 pt-2 float-xs-right">
                        <input type="checkbox" name="lu_division"
                            @if(!(old('lu_start_time') || old('lu_end_time'))
                            && $parkingLot->lu_division === App\Models\ParkingLot::LU_DIVISION_ENABLE || old('lu_division'))
                                {{ 'checked' }}
                            @endif
                        />
                        <lable class="font-weight-normal">24時間入出庫可能</lable>
                    </div>
                </div>
            </div>
            <div class="form-group d-flex pl-1">
                <label class="w-15 pl-5 w-xs-25 pt-2 font-weight-normal">再入庫可</label>
                <div class="w-15 w-xs-100 ml-2 pt-2 ">
                    <input type="checkbox" name="re_enter"
                           class="ml-xs-25" {{ old('re_enter', $parkingLot->re_enter) ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group d-flex pl-1">
                <label class="w-15 pl-5 w-xs-25 pt-2 font-weight-normal">現地清算</label>
                <div class="w-15 w-xs-100 ml-2 pt-2 ">
                    <input type="checkbox" name="local_payoff"
                           class="ml-xs-25" {{ old('local_payoff', $parkingLot->local_payoff) ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group d-flex pl-1">
                <label class="w-15 pl-5 w-xs-25 pt-2 font-weight-normal">ネット決済</label>
                <div class="w-15 w-xs-100 ml-2 pt-2 ">
                    <input type="checkbox" name="net_payoff"
                           class="ml-xs-25" {{ old('net_payoff', $parkingLot->net_payoff) ? 'checked' : '' }}>
                </div>
            </div>
            <div class="form-group d-flex pl-1">
                <label class="w-15 pl-5 w-xs-25 pt-2 font-weight-normal">注意事項</label>
                <div class="w-45 w-xs-75">
                    <textarea name="warn" class="form-control"
                              rows="3">{{ old('warn') ?? $parkingLot->warn }}</textarea>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    @if($errors->any() && $errors->has('image.*'))
                        <a class="nav-link active text-danger px-5" data-toggle="tab" href="#image">
                            画像
                        </a>
                    @else
                        <a class="nav-link active px-5" data-toggle="tab" href="#image">
                            画像
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($errors->any() && $errors->has('video.*'))
                        <a class="nav-link text-danger px-5" data-toggle="tab" href="#video">動画</a>
                    @else
                        <a class="nav-link px-5" data-toggle="tab" href="#video">動画</a>
                    @endif
                </li>
            </ul>
            <div class="tab-content border-top-0 border pb-2">
                <div id="image" class="container tab-pane active"><br>
                    <div class="row">
                        <div class="col-6 col-md-3 text-center p-xs-1">
                            <div class="d-flex justify-content-center align-items-center"
                                 @if($parkingLot->image1_url)
                                 style="display: none !important;"
                                 @endif
                                 id="div-input-image1"
                            >
                                <label for="btnEditInputUpload1" id="file-label-images1"
                                       class="file-label-images1 file-label-images">クリックまたはドラッグしてファイルを指定</label>
                                <input type="file" id="btnEditInputUpload1" name="image[1]"
                                       class="file-input-images1 file-input-images" accept="image/*"
                                       value="{{ $parkingLot->image1_url ?? '' }}" image="1">
                                <input type="text" name="isUpdateImage[0]" id="isUpdateImage1" class="input-is-update"
                                       value="0">
                            </div>
                            <div id="filePreviewEdit1" class="p-2 file-preview-area2 file-preview-area"
                                 @if($parkingLot->image1_url)
                                 style="display: block"
                                @endif>
                                <img class="img-upload-preview1 img-preview"
                                     src="{{ $parkingLot->image1_url ? asset('storage/'.$parkingLot->image1_url) : '' }}"
                                     alt="preview uploaded file">
                                <div class="img-upload-name-preview1 img-upload-name-preview"></div>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill delete-btn"
                                     image="1" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                </svg>
                            </div>
                            @if($errors->any() && $errors->has('image.1'))
                                <p class="text-danger float-left mt-2">{{$errors->first('image.1')}}</p>
                            @endif
                        </div>
                        <div class="col-6 col-md-3 text-center p-xs-1">
                            <div class="d-flex justify-content-center align-items-center"
                                 @if($parkingLot->image2_url)
                                 style="display: none !important;"
                                 @endif
                                 id="div-input-image2"
                            >
                                <label for="btnEditInputUpload2" id="file-label-images2"
                                       class="file-label-images2 file-label-images">クリックまたはドラッグしてファイルを指定</label>
                                <input type="file" id="btnEditInputUpload2" name="image[2]"
                                       class="file-input-images2 file-input-images" accept="image/*"
                                       value="{{ $parkingLot->image2_url ?? '' }}" image="2">
                                <input type="text" name="isUpdateImage[1]" id="isUpdateImage2" class="input-is-update"
                                       value="0">
                            </div>
                            <div id="filePreviewEdit2" class="p-2 file-preview-area2 file-preview-area"
                                 @if($parkingLot->image2_url)
                                 style="display: block"
                                @endif>
                                <img class="img-upload-preview2 img-preview"
                                     src="{{ $parkingLot->image2_url ? asset('storage/'.$parkingLot->image2_url) : '' }}"
                                     alt="preview uploaded file">
                                <div class="img-upload-name-preview2 img-upload-name-preview"></div>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill delete-btn"
                                     image="2" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                </svg>
                            </div>
                            @if($errors->any() && $errors->has('image.2'))
                                <p class="text-danger float-left mt-2">{{$errors->first('image.2')}}</p>
                            @endif
                        </div>
                        <div class="col-6 col-md-3 text-center p-xs-1">
                            <div class="d-flex justify-content-center align-items-center"
                                 @if($parkingLot->image3_url)
                                 style="display: none !important;"
                                 @endif
                                 id="div-input-image3"
                            >
                                <label for="btnEditInputUpload3" id="file-label-images3"
                                       class="file-label-images3 file-label-images">クリックまたはドラッグしてファイルを指定</label>
                                <input type="file" id="btnEditInputUpload3" name="image[3]"
                                       class="file-input-images3 file-input-images" accept="image/*"
                                       value="{{ $parkingLot->image3_url ?? '' }}" image="3">
                                <input type="text" name="isUpdateImage[2]" id="isUpdateImage3" class="input-is-update"
                                       value="0">
                            </div>
                            <div id="filePreviewEdit3" class="p-2 file-preview-area2 file-preview-area"
                                 @if($parkingLot->image3_url)
                                 style="
                                 display: block"
                                @endif>
                                <img class="img-upload-preview3 img-preview"
                                     src="{{ $parkingLot->image3_url ? asset('storage/'.$parkingLot->image3_url) : '' }}"
                                     alt="preview uploaded file">
                                <div class="img-upload-name-preview3 img-upload-name-preview"></div>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill delete-btn"
                                     image="3" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                </svg>
                            </div>
                            @if($errors->any() && $errors->has('image.3'))
                                <p class="text-danger float-left mt-2">{{$errors->first('image.3')}}</p>
                            @endif
                        </div>
                        <div class="col-6 col-md-3 text-center p-xs-1">
                            <div class="d-flex justify-content-center align-items-center"
                                 @if($parkingLot->image4_url)
                                 style="display: none !important;"
                                 @endif
                                 id="div-input-image4"
                            >
                                <label for="btnEditInputUpload4" id="file-label-images4"
                                       class="file-label-images4 file-label-images">クリックまたはドラッグしてファイルを指定</label>
                                <input type="file" id="btnEditInputUpload4" name="image[4]"
                                       class="file-input-images4 file-input-images" accept="image/*"
                                       value="{{ $parkingLot->image4_url ?? '' }}" image="4">
                                <input type="text" name="isUpdateImage[3]" id="isUpdateImage4" class="input-is-update"
                                       value="0">
                            </div>
                            <div id="filePreviewEdit4" class="p-2 file-preview-area2 file-preview-area"
                                 @if($parkingLot->image4_url)
                                 style="display: block"
                                @endif>
                                <img class="img-upload-preview4 img-preview"
                                     src="{{ $parkingLot->image4_url ? asset('storage/'.$parkingLot->image4_url) : '' }}"
                                     alt="preview uploaded file">
                                <div class="img-upload-name-preview4 img-upload-name-preview"></div>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle-fill delete-btn"
                                     image="4" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                </svg>
                            </div>
                            @if($errors->any() && $errors->has('image.4'))
                                <p class="text-danger float-left mt-2">{{$errors->first('image.4')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="video" class="container tab-pane fade"><br>
                    <div class="box">
                        <div class="row">
                            <div class="col-6 col-md-3 text-center p-xs-1">
                                <div class="d-flex file-1">
                                    <div class="d-flex justify-content-center align-items-center"
                                         @if($parkingLot->video1_url)
                                         style="display: none !important;"
                                         @endif
                                         id="div-input-video1"
                                    >
                                        <label for="btnVideoUpload1" class="file-label-videos1 file-label-videos">クリックまたはドラッグしてファイルを指定</label>
                                        <input type="file" id="btnVideoUpload1" name="video[1]"
                                               class="file-input-videos1 file-input-videos" accept="video/*" video="1">
                                        <input name="thumbnail[1]" class="file-input-thumbnail1" hidden>
                                    </div>
                                    <input type="text" name="isUpdateVideo[0]" id="isUpdateVideo1"
                                           class="input-is-update" value="0">
                                </div>
                                <div id="videoPreview1" class="p-2 video-preview-area1 video-preview-area"
                                     @if($parkingLot->video1_url)
                                     style="display: block"
                                    @endif
                                >
                                    <video controls class="video-upload-preview1 video-upload-preview">
                                        <source
                                            src="{{ $parkingLot->video1_url ? asset('storage/'.$parkingLot->video1_url) : '' }}">
                                    </video>
                                    <div class="video-upload-name-preview1 video-upload-name-preview"></div>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                         class="bi bi-x-circle-fill btn-delete-video" video="1" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                    </svg>
                                </div>
                                @if($errors->any() && $errors->has('video.1'))
                                    <p class="text-danger float-left mt-2">{{$errors->first('video.1')}}</p>
                                @endif
                            </div>
                            <div class="col-6 col-md-3 text-center p-xs-1">
                                <div class="d-flex file-2">
                                    <div class="d-flex justify-content-center align-items-center"
                                         @if($parkingLot->video2_url)
                                         style="display: none !important;"
                                         @endif
                                         id="div-input-video2"
                                    >
                                        <label for="btnVideoUpload2" class="file-label-videos2 file-label-videos">クリックまたはドラッグしてファイルを指定</label>
                                        <input type="file" id="btnVideoUpload2" name="video[2]"
                                               class="file-input-videos2 file-input-videos" accept="video/*" video="2">
                                        <input name="thumbnail[2]" class="file-input-thumbnail2" hidden>
                                    </div>
                                    <input type="text" name="isUpdateVideo[1]" id="isUpdateVideo2"
                                           class="input-is-update" value="0">
                                </div>
                                <div id="videoPreview2" class="p-2 video-preview-area2 video-preview-area"
                                     @if($parkingLot->video2_url)
                                     style="display: block"
                                    @endif
                                >
                                    <video controls class="video-upload-preview2 video-upload-preview">
                                        <source
                                            src="{{ $parkingLot->video2_url ? asset('storage/'.$parkingLot->video2_url) : '' }}">
                                    </video>
                                    <div class="video-upload-name-preview2 video-upload-name-preview"></div>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                         class="bi bi-x-circle-fill btn-delete-video" video="2" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                    </svg>
                                </div>
                                @if($errors->any() && $errors->has('video.2'))
                                    <p class="text-danger float-left mt-2">{{$errors->first('video.2')}}</p>
                                @endif
                            </div>
                            <div class="col-6 col-md-3 text-center p-xs-1">
                                <div class="d-flex file-3">
                                    <div class="d-flex justify-content-center align-items-center"
                                         @if($parkingLot->video3_url)
                                         style="display: none !important;"
                                         @endif
                                         id="div-input-video3"
                                    >
                                        <label for="btnVideoUpload3" class="file-label-videos3 file-label-videos">クリックまたはドラッグしてファイルを指定</label>
                                        <input type="file" id="btnVideoUpload3" name="video[3]"
                                               class="file-input-videos3 file-input-videos" accept="video/*" video="3">
                                        <input name="thumbnail[3]" class="file-input-thumbnail3" hidden>
                                    </div>
                                    <input type="text" name="isUpdateVideo[2]" id="isUpdateVideo3"
                                           class="input-is-update" value="0">
                                </div>
                                <div id="videoPreview3" class="p-2 video-preview-area1 video-preview-area"
                                     @if($parkingLot->video3_url)
                                     style="display: block"
                                    @endif
                                >
                                    <video controls class="video-upload-preview3 video-upload-preview">
                                        <source
                                            src="{{ $parkingLot->video3_url ? asset('storage/'.$parkingLot->video3_url) : '' }}">
                                    </video>
                                    <div class="video-upload-name-preview3 video-upload-name-preview"></div>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                         class="bi bi-x-circle-fill btn-delete-video" video="3" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                    </svg>
                                </div>
                                @if($errors->any() && $errors->has('video.3'))
                                    <p class="text-danger float-left mt-2">{{$errors->first('video.3')}}</p>
                                @endif
                            </div>
                            <div class="col-6 col-md-3 text-center p-xs-1">
                                <div class="d-flex file-4">
                                    <div class="d-flex justify-content-center align-items-center"
                                         @if($parkingLot->video4_url)
                                         style="display: none !important;"
                                         @endif
                                         id="div-input-video4"
                                    >
                                        <label for="btnVideoUpload4" class="file-label-videos4 file-label-videos">クリックまたはドラッグしてファイルを指定</label>
                                        <input type="file" id="btnVideoUpload4" name="video[4]"
                                               class="file-input-videos4 file-input-videos" accept="video/*" video="4">
                                        <input name="thumbnail[4]" class="file-input-thumbnail4" hidden>
                                    </div>
                                    <input type="text" name="isUpdateVideo[3]" id="isUpdateVideo4"
                                           class="input-is-update" value="0">
                                </div>
                                <div id="videoPreview4" class="p-2 video-preview-area4 video-preview-area"
                                     @if($parkingLot->video4_url)
                                     style="display: block"
                                    @endif
                                >
                                    <video controls class="video-upload-preview4 video-upload-preview">
                                        <source
                                            src="{{ $parkingLot->video4_url ? asset('storage/'.$parkingLot->video4_url) : '' }}">
                                    </video>
                                    <div class="video-upload-name-preview4 video-upload-name-preview"></div>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                         class="bi bi-x-circle-fill btn-delete-video" video="4" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z"/>
                                    </svg>
                                </div>
                                @if($errors->any() && $errors->has('video.4'))
                                    <p class="text-danger float-left mt-2">{{$errors->first('video.4')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-100">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary w-25 w-xs-50 btn-submit-code">
                        基本情報を編集して駐車スペース情報を更新
                    </button>
                </div>
                <div class="form-group text-center">
                    <button type="button" data-toggle="modal" data-target="#modelCancelEditParkinglot"
                            class="btn btn-secondary w-25 py-3 w-xs-50">
                        キャンセル
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal cancel Edit -->
    <div class="modal fade" id="modelCancelEditParkinglot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    登録を止めます。よろしいですか？
                </div>
                <div class="modal-footer">
                    <a href="{{ route('parkinglot.index') }}">
                        <button type="button" class="btn btn-primary">Ok</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var key = '{{ config('constants.KEY_GEOCODING_API') }}';
        var maxVideoSize = '{{ config('constants.MAX_SIZE_VIDEO_INPUT') }}';
        var messageRequired = '{{ __('message.member.required') }}'
        var checkZipCode = true;
        var messageSelectRequired = "{{ __('message.member.message_select_required') }}";
        var messageValidateLatitude = "{{ __('validation.parkinglot.validate_latitude') }}";
        var messageValidateLongitude = "{{ __('validation.parkinglot.validate_longitude') }}";
    </script>
    <script src="{{ mix('/js/find_address.js') }}"></script>
    <script src="{{ mix('/js/moment.min.js') }}"></script>
    <script src="{{ mix('/js/parking.js') }}"></script>
    <script src="{{ mix('/js/common/common-image-video-upload.js') }}"></script>
    <script src="{{ mix('/js/common/common-parking-time-picker.js') }}"></script>
@endsection
