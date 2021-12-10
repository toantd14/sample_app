@extends('owner::layouts.master')
@section('title', 'トップ')
@section('content')
<div class="top-page">
    <h2 class="mt-3 mb-3">お知らせ一覧</h2>
    <div class="top-page-content mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive table-content p-0">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" width="15%">日付</th>
                                    <th class="text-center" width="85%">タイトル</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td class="text-center text-wrap">{{ \Carbon\Carbon::parse($notification->created_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST')) }}</td>
                                    <td class="text-left text-wrap"><a href="">{{ $notification->notics_title }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
