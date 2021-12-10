@extends('owner::layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ mix('/css/notification.css') }}">
@endsection
@section('title', 'お知らせ編集')
@section('content')
    <div class="notifications-page">
        <div class="notifications-page-content mt-4">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form id="form-notifications" action="{{ route('notifications.update', ['notification' => $notification->notics_cd]) }}"
                  method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="row">
                    <div class="col-lg-12"><h2>お知らせ編集</h2></div>
                </div>
                <div class="row mt-2">
                    <label class="col-sm-2 col-form-label pl-5">お知らせ日 <span class="field_required">*</span></label>
                    <div class="col-12 col-sm-2">
                        <input type="text" class="form-control datepicker" name="created_at"
                               value="{{ old('created_at') ?? date_format($notification->created_at, config('constants.DATE.FORMAT_YEAR_FIRST')) }}" autocomplete="off">
                        @if ($errors->any() && $errors->has('created_at'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('created_at') }}</p>
                        @endif
                    </div>
                    <div class="col-0 col-sm-2">
                    </div>
                    <label class="col-sm-2 col-form-label pl-5">告知期間 <span class="field_required">*</span></label>
                    <div class="col-12 col-sm-2">
                        <input class="text-center form-control" name="announce_period" value="{{ old('announce_period') ?? $notification->announce_period }}">
                        @if ($errors->any() && $errors->has('announce_period'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('announce_period') }}</p>
                        @endif
                    </div>
                    <label class="col-sm-1 col-form-label">日間</label>
                </div>
                <div class="row form-group mt-2">
                    <label class="col-sm-2 col-form-label pl-5">タイトル <span class="field_required">*</span></label>
                    <div class="col-sm-7">
                        <input class="form-control" name="notics_title"
                               value="{{ old('notics_title') ?? $notification->notics_title }}">
                        @if ($errors->any() && $errors->has('notics_title'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('notics_title') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row form-group mt-2">
                    <label class="col-sm-2 col-form-label pl-5">駐車場 <span class="field_required">*</span></label>
                    <div class="col-sm-7">
                        <select class="form-control" name="parking_cd">
                            @foreach($parkings as $parking)
                                <option
                                    value="{{ $parking->parking_cd }}"
                                    @if($parking->parking_cd == old('parking_cd') || $notification->parkingLot->parking_cd == $parking->parking_cd)
                                        selected
                                    @endif
                                    > {{ $parking->parking_name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('title'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('parking_cd') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 col-form-label pl-5">内容 <span class="field_required">*</span></label>
                    <div class="col-10 mt-2">
                        <textarea name="notics_details" rows="14">{{ old('notics_details') ?? $notification->notics_details  }}</textarea>
                        @if ($errors->any() && $errors->has('notics_details'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('notics_details') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row action justify-content-center mt-4">
                    <div class="col-sm-2">
                        <button id="notifications-confirm" class="text-white d-block btn btn-primary mt-2">更新</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route('notifications.index') }}" class="text-white btn d-block  btn-secondary mt-2">キャンセル</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('owner::notifications.modal_submit')
    @if(session('success'))
        @include('owner::notifications.modal_success')
    @endif
@endsection
@section('js')
    <script>
        var messageRequired = '{{ __('message.message_required') }}'
        var messageSelectRequired = "{{ __('message.member.message_select_required') }}"
        var messageNumber = '{{ __('validation.integer', ['attribute' => '告知期間']) }}'
    </script>
    <script src="{{ mix('/js/notification.js') }}"></script>
    <script src="{{ mix('/js/jquery.validate.min.js') }}"></script>
@endsection
