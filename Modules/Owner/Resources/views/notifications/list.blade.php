@extends('owner::layouts.master')
@section('title', 'お知らせ一覧')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/list-notification.css') }}">
@endsection
@section('content')
<div class="top-page">
    <div class="mt-4">
        <h2>駐車場利用者へのお知らせ</h2>
    </div>
    @error ('date_public_from')
    <p class="mb-0 text-danger parking-form error">{{ $message }}</p>
    @enderror
    <div class="card-warning">
        <div class="card-body">
            <form action="{{ route('search.notice') }}" method="GET" id="search-notifications">
                <input type="hidden" name="search-notifications-validate">
                <div class="row">
                    <div class="col-md-2 pt-2 pl-5">お知らせ日<b class="text-danger">*</b></div>
                    <div class="col-md-3 form-group p-0 px-xs">
                        <input type="text" name="date_public_from" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" value="{{ Request::input('date_public_from') ?? old('date_public_from') }}" class="date-picker form-control w-100 pl-2 datepicker" autocomplete="off">
                    </div>
                    <div class="col-md-2 text-center">~</div>
                    <div class="col-md-3">
                        <input type="text" name="date_public_to" placeholder="{{ config('constants.DATE.INPUT_PLACEHOLDER_FORMAT') }}" value="{{ Request::input('date_public_to') ?? old('date_public_to') }}" class="date-picker form-control w-100 pl-2 datepicker" autocomplete="off">
                    </div>
                    <div class="col-md-2 "></div>
                    <div class="col-md-2 "></div>
                    <div class="col-md-10 form-group p-0 px-xs">
                        @if ($errors->any() && $errors->has('date_public_to'))
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('date_public_to') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 pt-2 pl-5">タイトル</div>
                    <div class="col-md-3 form-group p-0 px-xs">
                        <input type="text" name="title" value="{{ Request::input('title') ?? old('title')}}" class="form-control w-100">
                        @if ($errors->has('title') && $errors->count() == 1)
                            <p class="mb-0 text-danger parking-form error">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                    <div class="col-md-7 pt-2">（タイトルの一部を２文字以上指定）</div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 pt-2 pl-5">駐車場</div>
                    <div class="col-md-3 form-group p-0 px-xs">
                        <select class="form-control" name="parking_cd">
                            <option value="">-----</option>
                            @foreach($parkings as $parking)
                            <option value="{{ $parking->parking_cd }}" @if($parking->parking_cd == old('parking_cd'))
                                selected
                                @elseif($parking->parking_cd == Request::input('parking_cd'))
                                selected
                                @endif
                                >
                                {{ $parking->parking_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row px-xs">
                    <div class="col-md-2 p-0"></div>
                    <div class="col-md-2 p-0">
                        <button type="submit" class="btn btn-primary w-100 mt-2">検索</button>
                    </div>
                    <div class="col-md-1 p-0"></div>
                    <div class="col-md-2 p-0">
                        <a href="/" class="btn btn-secondary w-100 mt-2">戻る</a>
                    </div>
                    <div class="col-md-1 p-0"></div>
                    <div class="col-md-2 p-0">
                        <a href="{{ route('notifications.create') }}" class="btn btn-success w-100 mt-2">新規お知らせ登録</a>
                    </div>
                </div>
            </form>
            <div class="mt-4 d-flex mr-4">
                <a href="" id="prev-page" class="btn btn-secondary ml-auto mr-2"><</a>
                <a href="" id="next-page" class="btn btn-secondary">></a>
            </div>

            <div class="box-table pt-3">
                @if(session('deleteSuccess'))
                <p class="text-danger text-center">{{ session('deleteSuccess') }}</p>
                @endif
                <table class="table table-bordered border-0">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col" width="5%">No</th>
                            <th class="text-center" scope="col" width="15%">日付</th>
                            <th class="text-center" scope="col" width="70%">タイトル</th>
                            <th scope="col" class="border-0" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ownerNotices->count())
                        @foreach($ownerNotices as $index => $ownerNotice)
                        <tr>
                            <th class="text-center" scope="col">{{ $index + $ownerNotices->firstItem() }}</th>
                            <th class="text-center" scope="col">{{ date_format($ownerNotice->created_at, config('constants.DATE.FORMAT_YEAR_FIRST')) }}</th>
                            <th scope="col">
                                <a href="{{ route('notifications.edit', ['notification' => $ownerNotice->notics_cd]) }}">{{ $ownerNotice->notics_title }}</a>
                            </th>
                            <th scope="col" class="border-0">
                                <a class="btn btn-danger button-delete text-white" link="{{ route('notifications.destroy', ['notification' => $ownerNotice->notics_cd]) }}" {{ $ownerNotice->notics_title }}">削除</a>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                        @if(!$ownerNotices->count() && request()->routeIs('search.notice'))
                        <tr>
                            <th colspan="3">
                                <div class="alert alert-danger text-center" role="alert">
                                    {{ __('message.notifications.list_notifications_error') }}
                                </div>
                            </th>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div id="slot-paginate">
                    {{ $ownerNotices->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('owner::notifications.modal_delete')
@endsection
@section('js')
<script>
    var messageRequired = "{{ __('message.message_required') }}"
    var messageSelectRequired = "{{ __('message.member.message_select_required') }}"
    var mesSearchRequired = "{{ __('validation.notification.required_without_all') }}"
</script>
<script src="{{ mix('/js/notification.js') }}"></script>
@endsection
