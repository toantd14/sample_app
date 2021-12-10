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
    'response' => [
        'server_send_mail_error' => 'Error server could not send email',
    ],

    'register' => [
        'confirm' => '入力内容を登録します。よろしいですか？',
        'success' => '情報の登録が完了しました。',
        'exit' => 'キャンセル',
        'require_form' => '別のフォームを完成させる必要があります',
    ],

    'post_message' => [
        'success' => 'successfully',
        'exit' => 'cancel',
        'unauthorized' => 'unauthorized',
    ],

    'member' => [
        'required' => '入力して下さい',
        'confirm_required' => 'チェックがありません。',
        'message_select_required' => '選択して下さい。',
    ],

    'slot_parking' => [
        'message_select' => '選択して下さい',
        'confirm' => '駐車スペースの登録を実行します、よろしいですか？',
        'success' => '駐車スペースの登録が完了しました。',
        'update_success' => '駐車スペースの更新が完了しました。',
        'message_confirm_exit' => '駐車スペースの登録を終了します。よろしいですか？',
        'message_exist_parking_space' => '駐車場はご利用いただけません.',
    ],

    'search_use_situation' => [
        'required_without_all' => '利用年月、利用日、予約日、入金日のいずれかを一つを指定して下さい。',
    ],

    'menu_parking_lot' => [
        'update_success' => '駐車場利用のメニュー登録が完了しました。',
        'update_false' => '登録/更新に失敗しました。もう一度やり直して下さい。',
    ],

    'time_used' => [
        'no' => 'No',
        'parking_name' => '駐車場',
        'created_at' => '申込日',
        'reservation_day' => '予約日',
        'car_no_performance' => '車情報',
        'visit_no' => '利用区分',
        'reservation_use_kbn' => '請求区分',
        'payment_division' => '支払区分',
        'file_name' => '利用実績出力.csv'
    ]
];
