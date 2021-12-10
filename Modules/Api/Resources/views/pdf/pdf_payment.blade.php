@php
use App\Models\UseSituation;
use App\Models\OwnerBank;
@endphp
@extends('api::layouts.master')
@section('content')
<div class="container">
  <span class="col-12 text-right pt-3 pb-2">{{ formatFullDateStringJapanese($useSituation->created_at) }}</span>
  <h2 class="col-12 text-center pt-2 pb-5">請求書</h2>
  <div class="col-12 pb-5">
    <div class="col-6 pr-4">
      <p class="pb-3">{{ $useSituation->uniqueUserName() }}</p>
      <p>下記の通り御請求申し上げます。</p>
      <p>ご確認の上お振込みの程よろしくお願い致します。</p>
    </div>
    <div class="col-6 pl-4">
      <div class="certification">
        <p>{{ $useSituation->owner->name_c }}</p>
        <p>〒{{ $useSituation->owner->zip_cd }}</p>
        <p>{{ $useSituation->owner->prefecture->prefectures_name . $useSituation->owner->municipality_name . $useSituation->owner->townname_address}}</p>
        <p>{{ $useSituation->owner->building_name }}</p>
        <p>{{ $useSituation->owner->tel_no }}</p>
        <div class="stamp">
          <img src="data:image/png;base64,{{ $useSituation->owner->stamp }}" alt="">
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 pb-2">
    <table class="table table-bordered">
      <tr>
        <th colspan="2" class="text-center">適用</th>
        <th width="25%" class="text-center">数量</th>
        <th width="25%" class="text-center">小計</th>
      </tr>
      <tr>
        <th colspan="2" class="text-left">
          <p class="mb-0">駐車料</p>
          <span class="pl-2 pr-2">
            {{ $useSituation->uniqueUserTimeUseTo() }}
            ~
            {{ formatDateString($useSituation->end_day, 'm/d') }}
          </span>
        </th>
        <td class="text-center">1台</td>
        <td class="text-right">{{ formatPrice($useSituation->money_reservation) }}</td>
      </tr>
      <tr>
        <th colspan="3" class="text-center">御請求金額合計</th>
        <td class="text-right">{{ formatPrice($useSituation->money_reservation) }}</td>
      </tr>
    </table>
  </div>
  <div class="col-12">
    <p>* お振込先</p>
    <p>
      <span style="min-width: 150px;display: inline-block;">{{ $useSituation->owner->ownerBank->bank_name }}銀行</span>
      <span class="pl-3">{{ $useSituation->owner->ownerBank->branch_name }}支店</span>
    </p>
    <p>
      <span style="min-width: 150px;display: inline-block;">({{ $useSituation->owner->ownerBank->bank_cd }})</span>
      <span class="pl-3">({{ $useSituation->owner->ownerBank->branch_cd }})</span>
    </p>
    <p>
      <span>{{ OwnerBank::TYPE_BANK[$useSituation->owner->ownerBank->account_type] }}</span>
      <span class="pl-5">{{ $useSituation->owner->ownerBank->account_no }}</span>
    </p>
    <p>
      <span>株式会社{{ $useSituation->owner->ownerBank->account_name }}</span>
    </p>
    <p><span>(カ){{ $useSituation->owner->ownerBank->account_kana }}</span></p>
    <p>* お支払い期日</p>
    <p>
      {{ $useSituation->deadlinePay() }}までにお振込み下さい。
    </p>
    <p>
      お振込み手数料はお客様にてご負担お願い致します。
    </p>
  </div>
</div>
@endsection
