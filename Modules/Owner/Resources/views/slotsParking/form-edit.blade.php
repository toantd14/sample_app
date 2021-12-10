<form id="form-edit" action="{{ route('slots-parking.update', ['slots_parking' => $slotParking->serial_no]) }}"
    role="form">
    @csrf
    <input type="hidden" value="{{ $slotParking->serial_no }}" name="serial_no">
    <input type="hidden" value="{{ $slotParking->parking_cd }}" name="parking_cd">
    <div class="form-group row">
        <label class="label-text pt-2 col-4 col-md-2 font-weight-normal">駐車場形式 <b class="text-danger">*</b></label>
        <div class="col-8 col-md-10">
            <select name="parking_form" class="form-control w-75">
                <option value="" {{ $slotParking->parking_form == null ? 'selected' : '' }}>--選択して下さい--</option>
                <option value="0" {{ $slotParking->parking_form == 0 ? 'selected' : '' }}>平面駐車場(ロック式)</option>
                <option value="1" {{ $slotParking->parking_form == 1 ? 'selected' : '' }}>平面駐車場(ロックレス式)</option>
                <option value="2" {{ $slotParking->parking_form == 2 ? 'selected' : '' }}>平面駐車場(ゲート式)</option>
                <option value="3" {{ $slotParking->parking_form == 3 ? 'selected' : '' }}>機械式立体駐車場</option>
                <option value="4" {{ $slotParking->parking_form == 4 ? 'selected' : '' }}>自走式立体駐車場</option>
            </select>
            <p class="mb-0 text-danger parking_form_error error"></p>
        </div>
    </div>
    <div class="form-group row">
        <label class="label-text pt-2 col-4 col-md-2 font-weight-normal">車種 <b class="text-danger">*</b></label>
        <div class="col-8 col-md-10">
            <input type="checkbox" class="check-type" {{ $slotParking->kbn_standard == 1 ? 'checked' : '' }}
                name="car_type[kbn_standard]" value="1">
            <label class="mr-3 ml-1">普通</label>
            <input type="checkbox" class="check-type" {{ $slotParking->kbn_3no == 1 ? 'checked' : '' }}
                name="car_type[kbn_3no]" value="1">
            <label class="mr-3 ml-1">３ナンバー</label>
            <input type="checkbox" class="check-type" {{ $slotParking->kbn_lightcar == 1 ? 'checked' : '' }}
                name="car_type[kbn_lightcar]" value="1">
            <label class="mr-3 ml-1">軽自動車</label>
            <label for="car_type[kbn_standard]" generated="false" class="error" hidden></label>
            <label for="car_type[kbn_3no]" generated="false" class="error" hidden></label>
            <label for="car_type[kbn_lightcar]" generated="false" class="error" hidden></label>
            <p class="mb-0 text-danger check_type_error error car_type_error"></p>
            <p id="car_type_error_edit" class="error"></p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-md-2 font-weight-normal label-text pt-2">車幅 <b class="text-danger">*</b></label>
        <div class="col-3 col-md-2">
            <input value="{{ $slotParking->car_width }}" name="car_width" type="number" class="form-control">
            <p class="mb-0 text-danger car_width_error error"></p>
        </div>
        <label class="col-1 font-weight-normal">m</label>
        <div class="offset-md-2"></div>
        <label class="col-2 col-md-2 font-weight-normal label-text pt-2">車長 <b class="text-danger">*</b></label>
        <div class="col-3 col-md-2">
            <input name="car_length" value="{{ $slotParking->car_length }}" type="number" class="form-control">
            <p class="mb-0 text-danger car_length_error error"></p>
        </div>
        <label class="col-1 col-md-1 font-weight-normal">m</label>
    </div>
    <div class="form-group row">
        <label class="col-2 col-md-2 font-weight-normal label-text pt-2">車高 <b class="text-danger">*</b></label>
        <div class="col-3 col-md-2">
            <input name="car_height" value="{{ $slotParking->car_height }}" type="number" class="form-control">
            <p class="mb-0 text-danger car_height_error error"></p>
        </div>
        <label class="col-1 col-md-1 font-weight-normal">m</label>
        <div class="offset-md-2"></div>
        <label class="col-2 col-md-2 font-weight-normal label-text pt-2">車重 <b class="text-danger">*</b></label>
        <div class="col-3 col-md-2">
            <input name="car_weight" value="{{ $slotParking->car_weight }}" type="number" class="form-control">
            <p class="mb-0 text-danger car_weight_error error"></p>
        </div>
        <label class="col-1 col-md-1 font-weight-normal">t</label>
    </div>
    <div class="form-group row">
        <label class="col-2 font-weight-normal label-text pt-2">記号 </label>
        <div class="col-3 col-md-2">
            <input name="space_symbol" id="space_symbol" value="{{ $slotParking->space_symbol }}" type="text" class="form-control">
            <p class="mb-0 text-danger space_symbol_error error"></p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 font-weight-normal label-text pt-2">駐車番号 <b class="text-danger">*</b></label>
        <div class="col-4 col-md-2">
            <input name="space_no_from" id="space_no_from" value="{{ $spaceNo['spaceNoForm'] }}" type="number" class="form-control">
            <p class="mb-0 text-danger space_no_from_error error"></p>
        </div>
        <label class="col-1 font-weight-normal text-center">~</label>
        <div class="col-4 col-md-2">
            <input name="space_no_to" disabled id="space_no_to" value="{{ $spaceNo['spaceNoTo'] }}" type="number" class="form-control">
            <p class="mb-0 text-danger space_no_to_error error"></p>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-3 offset-lg-2 offset-sm-2"></div>
        <button class="col-6 col-lg-3 col-sm-3 btn btn-primary mt-2 text-light">更新</button>
        <div class="offset-3 offset-lg-1 offset-sm-1"></div>
        <div class="offset-3 offset-lg-1 offset-sm-1"></div>
        <a link="{{ route('parkinglot.index') }}"
            class="cancel text-white col-6 col-lg-3 col-sm-3 btn btn-secondary mt-2">
            戻る
        </a>
        <div class="offset-3 offset-lg-2 offset-sm-2"></div>
    </div>
</form>
<div class="modal fade show" id="modalConfirmEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">駐車スペースの更新を実行します、よろしいですか？</h6>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-footer">
                <button id="submit-edit" class="btn btn-primary" data-dismiss="modal" aria-label="Close">OK</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">キャンセル</button>
            </div>
        </div>
    </div>
</div>
