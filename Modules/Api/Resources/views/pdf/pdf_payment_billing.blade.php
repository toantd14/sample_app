@php
    use App\Models\UseSituation;
    use App\Models\OwnerBank;
@endphp
@extends('api::layouts.master')
@section('content')
    <div class="container">
        <div class="col-12 text-right pt-3 pb-2">No {{ $useSituation->receipt_number }}</div>
        <div class="col-12 text-right pb-2">{{ formatFullDateStringJapanese($useSituation->created_at) }}</div>
        <h2 class="col-12 text-center pt-2 pb-5">領収書</h2>
        <div class="col-12 pb-5">
            <div>
                {{ $useSituation->uniqueUserName() }}
            </div>
            <div class="offset-3 col-6">
                <p>金額</p>
                <p class="bill-price">{{ formatPrice($useSituation->parking_fee) }}</p>
                <p>但し　駐車料金として上記正に領収致しました。</p>
            </div>
        </div>
        <div class="offset-8 col-4">
            <div class="certification">
                <p>{{ $useSituation->owner->name_c }}</p>
                <p>〒{{ $useSituation->owner->zip_cd }}</p>
                <p>{{ $useSituation->owner->prefecture->prefectures_name . $useSituation->owner->municipality_name . $useSituation->owner->townname_address}}</p>
                <p>{{ $useSituation->owner->building_name }}</p>
                <p>TEL　{{ $useSituation->owner->tel_no }}</p>
                <div class="stamp">
                    <img src="data:image/png;base64,{{ $useSituation->owner->stamp }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
