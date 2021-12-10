<?php
return [
    'url_api_member_payment' => env('URL_API_MEMBER_PAYMENT', 'https://gw.ccps.jp/memberpay.aspx'),
    'lang' => 'ja',
    'start_sub_string' => 5,

    // api payment return:
    'api_rst_success' => 1, // success = 1
    'api_rst_fail' => 2, // false = 2
    'api_ec_success' => 'ER000000000', //success
    'api_result_code' => '000', //success execMemberPurchase string
    'api_result_code_number' => 0, //success execMemberPurchase number

    // Config params call api payment by token method:
    'sid' => env('SID_PAYMENT', 100530), //id of shop (id test)
    'svid' => 1, // Service type (1: Permanent)
    'ptype' => 1, // Processing type (specify "1: token payment")
    'job' => 'CAPTURE', // Payment job type (CAPTURE: Temporary actual simultaneous processing)
    'rt' => 2, // Result reply method (2: Response)

    //data test
    'cardNo' => '9946********5411',
    'expireMonth' => '12',
    'expireYear' => '2020',
    'firstName' => 'do',
    'lastName' => 'thanh',
    'phoneNumber' => '031****234',
    'securityCode' => '***',

    //secret key
    'secret_key' => 'carparking-register-parking-2020',
    'encrypt_method' => 'AES-256-CBC',
    'secretIV' => '1234123412341234',

    //define Message by errorCode payment return
    'error_message' => [
        'D1GS61' => '対応していないカードブランド',
        'D41S61' => '決済検索値の不一致のエラー',
        'P02P02' => '通信エラー、タイムアウトエラー',
        'P05P07' => '送信元IPのエラー',
        'P06P07' => '送信元URLのエラー',
        'P64P06' => '電話番号形式違反',
        'P65P06' => 'アドレスの入力形式違反',
        'P68P09' => '決済金額下限エラー',
        'P68P0B' => '当月決済金額合計上限エラー',
        'P68P0G' => '1カード番号失敗決済回数上限(回/日)',
        'PC6P0D' => '海外発行カード利用不可エラー',
        'P05P0D' => '海外IP拒否エラー',
        'PC1P04' => 'カード番号桁数不足',
        'PC1P06' => 'カード番号エラー',
        'PC2P03' => '有効期限形式違反',
        'PC2G04' => '有効期限切れエラー',
        'PC3P05' => 'セキュリティコードエラー',
        'PC4P06' => 'カード名義形式違反',
        'P72P0D' => '重複決済防止エラー',
        'R11P06' => 'トークン関連エラー',
        'T01P07' => 'トークンエラー',
        'T52G01' => 'カード会社による認証エラー',
        'T52G02' => 'カード会社による認証エラー',
        'T52G04' => '有効期限切れエラー',
        'T52G07' => '分割回数関連エラー',
        'T52G12' => 'セキュリティコードエラー',
        'T52G13' => 'カード会社による認証エラー',
        'T52G92' => 'カード会社による認証エラー',
    ]
];
