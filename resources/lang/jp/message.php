<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'register' => [
        'confirm' => '入力内容を登録します。よろしいですか？',
        'success' => '情報の登録が完了しました。',
        'exit' => 'キャンセル',
        'email_address_already_exists' => 'メールアドレスは既に存在します。',
        'must_create_new_owner' => '会員情報を先に登録してください。'
    ],

    'contract' => [
        'contractID_invalid' => '契約書は存在しません。',
        'prefecture_invalid' => '都道府県名は存在しません。',
    ],

    'confirm_certification_success' => '確認コードが認証できました',

    'slot_parking' => [
        'message_select' => '選択して下さい',
        'confirm' => '駐車スペースの登録を実行します、よろしいですか？',
        'success' => '駐車スペースの登録が完了しました。',
        'business_hours' => '24時間',
        'message_exist_parking_space' => '既に同じ駐車スペースが登録されています。登録内容を確認してやり直して下さい。',
    ],

    'menu' => [
        'month' => [
            'create_success' => '月極め内容の登録が完了しました。',
            'update_success' => '月極め内容の更新が完了しました。',
        ],
        'day' => [
            'create_success' => '日貸し内容の登録が完了しました。',
            'update_success' => '日貸し内容の更新が完了しました。',
        ],
        'period' => [
            'data_missing' => '曜日条件、時間条件、日付指定のいずれかを全て入力して下さい',
            'data_required' => '',
            'create_success' => '期間貸し内容の登録が完了しました。',
            'update_success' => '期間貸し内容の更新が完了しました。',
        ],
        'time' => [
            'store_errors' => '既に登録済みで内容を確認して下さい。',
            'message_confirm_delete' => '選択した時間貸し内容を削除します。よろしいですか？！',
            'cancel' => 'キャンセル',
        ],
        'store_or_update_success' => '期間貸し内容の登録が完了しました。',
        'error' => 'エラーが発生しました'
    ],

    'payment' => [
        'error' => '決済が失敗しました'
    ],

    'response' => [
        'unauthorized' => 'あなたは無許可です',
        'token_expired' => 'トークンが期限切れ',
        'token_expired_or_incorrect' => '不正または期限切れのトークン',
        'refresh_token_does_not_exist' => '更新トークンは存在しません',
        'success' => '成功しました。',
        'invalid_email_or_password' => '無効なメールアドレスまたはパスワード',
        'http_internal_server_error' => '終わりに問題が発生しました',
        'invalid_format_datetime_exception' => '無効な形式の日時例外',
        'url_not_exist' => 'URLは存在しません',
    ],

    'menu_parking_lot' => [
        'update_success' => '駐車場利用のメニュー登録が完了しました。',
        'update_false' => '登録/更新に失敗しました。もう一度やり直して下さい。',
        'create_success' => '成功する',
        'create_or_update' => '登録/更新に失敗しました。もう一度やり直して下さい。',
        'delete_success' => '成功を削除',
        'delete_false' => '削除できませんでした',
        'menu_time_success' => '時間貸し内容の登録が完了しました。',
        'menu_time_errors' => '既に登録済みで内容を確認して下さい。',
        'create_menu_before' => 'メニューを登録してください。',
        'not_found_exception' => '駐車場が見つかりません。'
    ],

    'error' => 'エラーが発生しました。',
    'success' => '成功しました。',

    'ownpassword' => [
        'your_password_has_been_update' => 'パスワードが更新されました！',
        'new_password_same_current_password' => '新しいパスワードを現在のパスワードと同じにすることはできません。別のパスワードを選択してください。',
        'password_confirmation_not_same_password' => '新しいパスワードと再入力パスワードが一致しません。',
        'error' => 'エラーが発生しました'
    ],

    'prefecture_not_found' => '都道府県が見つかりません',

    'owner' => [
        'update_success' => '更新に成功',
        'error' => 'エラーが発生しました'
    ],
    'admin' => [
        'update_success' => '情報の更新が完了しました。',
        'error' => 'エラーが発生しました'
    ],
    'owner_bank' => [
        'success' => '情報の更新が完了しました。',
        'validate' => '入力して下さい',
        'error' => 'エラーが発生しました'
    ],

    'parking_lot' => [
        'not_exists' => "駐車場が存在していません。",
        'search_results_null' => '条件と一致するデータがありません。',
        'lutime_between_start_time' => '入庫と出庫には、営業時間の間に指定して下さい。',
    ],

    'user_token' => "tokenは存在しません",

    'message_required' => '入力して下さい',

    'message_number_required' => '数字を入力してください',

    'message_number_price' => '駐車料は1〜99999までにしてください',

    'notifications' => [
        'list_notifications_error' => '条件と一致するお知らせがありません。やり直して下さい。'
    ],

    'time_use' => [
        'list_time_use_error' => '条件と一致するデータがありません。やり直して下さい。',
        'has_any_result_for_search' => '条件と一致するデータがありません。',
        'has_any_param_for_search' => '利用年月、利用日、予約日、入金日のいずれかを一つを指定して下さい。'
    ],

    'zipcode_not_found' => '（指定された）郵便番号は見つかりません。',

    'use_booking_not_exists' => '受付コードが見つかりません。',

    'time_flag' => [
        'rent_by_month' => '月極めはOffなので、設定できません。',
        'rent_by_period' => '期間(定期)貸しはOffなので、設定できません。',
        'rent_by_day' => '日貸しはOffなので、設定できません。',
        'rent_by_hour' => '時間貸しはOffなので、設定できません。',
    ],

    'period_time_validate' => ':fromから:toまでの期間以内にしてください。',

    'check_date_less_now' => '予約日は現在の日付より前に選択できません。',

    'check_hour_less_now' => '予約時間は現在の時間付より前に選択できません。',

    'check_weekday_fit' => '指定した時間駐車時間以外なので、予約できません。',

    'check_price_greater_zero' => '料金は0より大きな値を指定してください。',

    'check_price_exceeded_one_million' => '料金は100万より小さな値を指定してください。',

    'check_date_fit' => '指定した時間は駐車時間帯以外なので、予約できません。',

    'check_minimum_month' => ':monthヶ月以上予約してください。',

    'notice_not_exists'=> 'お知らせコードが存在していません。',

    'review' => [
        'allow_one_review_for_parking' => '駐車場ごとに1回だけ評価されます。'
    ],

    'question_category_not_found' => '質問のタイプが見つけません',

    'not_ready' => 'ユーザーのすべての機能が完了していません。',

    'parking' => [
        'create_success' => '駐車場の登録が完了しました。',
        'edit_success' => '駐車場の更新が完了しました。',
    ],

    'use_situation_not_found' => '利用状況が見つかりません。'
];
