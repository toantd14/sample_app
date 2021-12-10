<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'login' => [
        'attribute_required' => '入力して下さい',
        'error' => 'ログイン情報が一致しません。やり直して下さい。'
    ],

    'set_password' => [
        'certification_error' => '認証コードが一致しません。確認メールの認証コードを確認して下さい。',
        'password_error' => 'パスワードの条件に該当しません。',
        'success' => '認証が成功しました。',
    ],

    'parkinglot' => [
        'required' => '入力して下さい',
        'format_err' => '正しく入力して下さい',
        'sale_from_to' => '営業時間（From）≦ 営業時間（To）となるように入力してください。',
        'lu_from_to' => '入庫 ≦ 出庫となるように入力してください。',
        'validate_latitude' => '緯度の書式が正しくありません。 ',
        'validate_longitude' => '経度の書式が正しくありません。',
    ],

    'member' => [
        'required' => '入力して下さい',
        'format_err' => '正しく入力して下さい'
    ],

    'data_required' => '入力して下さい',

    'accepted' => ':attributeを承認してください。',
    'active_url' => ':attributeは正しいURLではありません。',
    'after' => ':attributeは:date以降の日付にしてください。',
    'after_or_equal' => ':attributeには:date以降の日付にしてください。',
    'alpha' => ':attributeは英字のみにしてください。',
    'alpha_dash' => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num' => ':attributeは英数字のみにしてください。',
    'array' => ':attributeは配列にしてください。',
    'before' => ':attributeは:date以前の日付にしてください。',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attributeは:min〜:maxまでにしてください。',
        'file' => ':attributeは:min〜:max KBまでのファイルにしてください。',
        'string' => ':attributeは:min〜:max文字にしてください。',
        'array' => ':attributeは:min〜:max個までにしてください。',
    ],
    'boolean' => ':attributeはtrueかfalseにしてください。',
    'confirmed' => '変更後のパスワードと変更後のパスワード（確認）の値が一致しません。',
    'date' => ':attributeは正しい日付ではありません。',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attributeは":format"書式と一致していません。',
    'different' => ':attributeは:otherと違うものにしてください。',
    'digits' => ':attributeは:digits桁にしてください',
    'digits_between' => ':attributeは:min〜:max桁にしてください。',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attributeを正しいメールアドレスにしてください。',
    'filled' => ':attributeは必須です。',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => '選択された:attributeは正しくありません。',
    'file' => 'The :attribute must be a file.',
    'image' => ':attributeは画像にしてください。',
    'in' => '選択された:attributeは正しくありません。',
    'integer' => ':attributeは整数にしてください。',
    'ip' => ':attributeを正しいIPアドレスにしてください。',
    'max' => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file' => ':attributeは:max KB以下のファイルにしてください。.',
        'string' => ':attributeは:max文字以下にしてください。',
        'array' => ':attributeは:max個以下にしてください。',
    ],
    'mimes' => ':attributeは:valuesタイプのファイルにしてください。',
    'min' => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file' => ':attributeは:min KB以上のファイルにしてください。.',
        'string' => ':attributeは:min文字以上にしてください。',
        'array' => ':attributeは:min個以上にしてください。',
    ],
    'not_in' => '選択された:attributeは正しくありません。',
    'numeric' => ':attributeは数字にしてください。',
    'regex' => ':attributeの書式が正しくありません。',
    'required' => ':attributeは必須です。',
    'required_if' => ':otherが:valueの時、:attributeは必須です。',
    'required_with' => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all' => ':valuesが存在する時、:attributeは必須です。',
    'required_without' => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same' => ':attributeと:otherは一致していません。',
    'size' => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file' => ':attributeは:size KBにしてください。.',
        'string' => ':attribute:size文字にしてください。',
        'array' => ':attributeは:size個にしてください。',
    ],
    'string' => ':attributeは文字列にしてください。',
    'timezone' => ':attributeは正しいタイムゾーンをしていしてください。',
    'unique' => ':attributeは既に存在します。',
    'url' => ':attributeを正しい書式にしてください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'from_time_than_to_time' => '時間には時間に以降の日付にしてください。',
    'positive_integer' => '価格は1以上にしてください。',
    'number_integer' => '価格は整数にしてください。',

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'lat' => '緯度',
        'lon' => '経度',
        'radius' => '半径',
        'page' => 'ページ',
        'pageSize' => 'ページサイズ',
        "kubun" => "区分",
        "name_c" => "ご契約名",
        "person_man" => "担当者名",
        "department" => "部署名",
        "hp_url" => "法人HP-URL",
        "mail_add" => "メールアドレス",
        "zip_cd" => "住所",
        "code" => "住所",
        "prefectures" => '都道府県',
        "municipality_name" => "市区町村郡",
        "townname_address" => "町域以下番地",
        "building_name" => "建物等",
        "tel_no" => "電話番号",
        "fax_no" => "FAX番号",
        "parkingID" => "駐車場管理コード",
        "satisfation" => "満足",
        "location" => "位置",
        "fee" => "料金",
        "comment" => "コメント",
        "easeStopping" => "駐車の便利さ",
        'place_id' => 'プレイスID',
        'keyword' => 'キーワード',
        'sort' => 'ソート',
        'month_price' => '月額駐車料',
        'minimum_use' => '最低利用月',
        'period_price' => '駐車料',
        'long' => '経度',
        'car_type' => '車種',
        'car_width' => '車幅',
        'car_length' => '車の長さ',
        'car_height' => '車の高さ',
        'car_weight' => '車の重さ',
        'space_symbol' => '駐車符号',
        'space_no_from' => '駐車番号から',
        'space_no_to' => '駐車番号まで',
        'to_time' => '時間に',
        'from_time' => '時間に',
        'price' => '価格',
        'period_week_data' => '曜日条件',
        'period_week' => '期間週',
        'month_flg' => '月極め',
        'period_flg' => '期間(定期)貸し',
        'time_flg' => '時間貸し',
        'period_timeflg' => ' 時間条件',
        'period_fromtime' => '時間からの期間',
        'period_totime' => '時々',
        'period_fromday' => '日からの期間',
        'period_today' => '日々',
        'period_dayflg' => '日付指定',
        'bank_cd' => '銀行ID',
        'bank_name' => '銀行名',
        'branch_cd' => '施設ID',
        'branch_name' => '施設名',
        'account_type' => '口座タイプ',
        'account_name' => '口座名義',
        'account_kana' => '口座名義（かな',
        'notics_title' => 'タイトル',
        'announce_period' => '告知期間',
        'notics_details' => '内容',
        'day_price' => '日額',
        'title' => '題名',
        'date_public_to' => '公開日',
        'date_public_from' => '公開日',
        'warn' => '注意事項',
        'owner_cd' => 'オーナー',
        'use_day_from' => '使用日から',
        'use_day_to' => '日に使う',
        'reservation_day_from' => '予約日から',
        'reservation_day_to' => '予約日',
        'payment_day_from' => 'お支払い日から',
        'payment_day_to' => 'お支払い日',
        'bookingTime.endDate' => '利用終了日',
        'bookingTime.bookingType' => 'メニュー区分',
        'bookingTime.startDate' => '利用開始日',
        'bookingTime.startTime' => '予約開始時間',
        'bookingTime.endTime' => '予約終了時間',
        'bookingTime.month' => '利用期間（ヶ月）',
        'customerInfo.carNo' => '予約車番',
        'customerInfo.carType' => '予約車種',
        'customerInfo.customerType' => '申込区分',
        'customerInfo.firstName' => '申込者名（姓）',
        'customerInfo.lastName' => '申込者名（名）',
        'customerInfo.firstNameKana' => '申込者名（姓）カナ',
        'customerInfo.lastNameKana' => '申込者名（名）カナ',
        'customerInfo.phoneNumber' => '申込者名（名）カナ',
        'paymentInfo.paymentType' => '予約支払方法',
        'paymentInfo.paymentToken' => '決済トークン',
        'paymentInfo.paymentPhoneNumber' => '連絡先',
        'contract.prefectures' => '都道府県名',
        'contract.municipality' => '所在地_市区町村郡',
        'contract.townname' => '所在地_町域名＋番地',
        'contract.contractorName' => '契約者名',
        'contract.contractID' => 'シリアル',
        'contract.telPhone' => '電話番号',
        'noticeID' => 'お知らせコード',
        'created_at_from' => '登録日',
        'created_at_to' => '登録日',
        'updated_at_from' => '更新日',
        'updated_at_to' => '更新日',
        'categoryID' => 'カテゴリーID',
        'feedback' => 'フィードバック',
        'bookingID' => '予約ID',
        'account_no' => '口座番号',
        'latitude' => '緯度',
        'longitude' => '経度',
    ],

    'values' => [
        'period_week' => [
            '0' => 'オン'
        ],
        'period_timeflg' => [
            '0' => 'オン'
        ],
        'period_dayflg' => [
            '0' => 'オン'
        ],
        'period_flg' => [
            '0' => 'オン'
        ],
        'month_flg' => [
            '0' => 'オン'
        ],
    ],

    'notification' => [
        'insert_success' => 'お知らせの登録が完了しました。',
        'update_success' => 'お知らせの更新が完了しました。',
        'delete_success' => '削除が完了しました。',
        'date_from_to' => 'お知らせ日（From）≦ お知らせ日（To）となるように入力してください。',
        'required_without_all' => 'お知らせ日、タイトル、駐車場のいずれかを一つを指定して下さい。',
    ],

    'search_use_situation' => [
        'required_without_all' => '利用年月、利用日、予約日、入金日のいずれかを一つを指定して下さい。',
        'use_day_validate' => '利用日（From）≦ 利用日（To）となるように入力してください。',
        'reservation_day_validate' => '予約日（From）≦ 予約日（To）となるように入力してください。',
        'payment_day_validate' => '入金日（From）≦ 入金日（To）となるように入力してください。',
    ],

    'space_no_error' => '駐車番号から≦駐車番号までとなるように入力してください。',

    'period_time_from_to' => '時間条件（From）< 時間条件（To）となるように入力してください。',

    'period_day_from_to' => '日付指定（From）< 日付指定（To）となるように入力してください。',

    'menutime_from_to' => '駐車時間帯（From）< 駐車時間帯（To）となるように入力してください。',

    'created_from_to_validate' => '登録日（From）≦ 登録日（To）となるように入力してください。',

    'updated_from_to_validate' => '更新日（From）≦ 更新日（To）となるように入力してください。',

    'period_week_or_time' => '曜日条件と日付指定のいずれかを選択してください。',
];
