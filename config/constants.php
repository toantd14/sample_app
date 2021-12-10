<?php

return [
    'MAIL_NO_REPLY' => 'noreply@domain.com',
    'SUBJECT_MAIL_REGISTER' => 'Confirm registrations',
    'SUBJECT_MAIL_FEEDBACK' => 'Customer feedback',
    'YEAR' => 'Y',
    'HOUR' => 'h',
    'MIN' => 'i',
    'DATE' => [
        'FORMAT_YEAR_FIRST' => 'Y/m/d',
        'INPUT_PLACEHOLDER_FORMAT' => 'yyyy/mm/dd',
        'FORMAT_MONTH_DAY' => 'm/d',
    ],
    'TIME' => [
        'HOUR_MIN' => 'h:i',
        'EXPIRED_TOKEN_HOUR' => 2,
        'EXPIRED_REFRESH_TOKEN_DAY' => 2,
        'START_OF_DAY' => '00:00',
        'END_OF_DAY' => '24:00',
        'INPUT_PLACEHOLDER_FORMAT' => 'HH:MM'
    ],
    'PAGE_DEFAULT' => 1,
    'PAGE_LIMIT' => 15,
    'USE_SITUATION_PAGE_LIMIT' => 20,
    'USE_NOTICE_PAGE_LIMIT' => 20,
    'SLOT_PARKING_PAGE_ITEM' => 20,
    'PARKING_SPACE_PAGE_ITEM' => 50,
    'PATH' => [
        'PUBLIC' => 'public',
        'IMAGES' => 'images',
        'VIDEOS' => 'videos',
    ],
    'LENGTH_STRING_TOKEN' => 60,

    'API' => [
        'DATE_TIME_FORMAT' => 'c',
        'HOUR_MIN' => 'H:i',
        'DATE_FORMAT' => 'Y-m-d',
    ],
    'URL_GET_INFOR_USER' => [
        'FACEBOOK' => 'https://graph.facebook.com/v3.1/me?fields=name,email&access_token=',
        'LINE' => 'https://api.line.me/v2/profile',
        'GOOGLE' => 'https://oauth2.googleapis.com/tokeninfo?id_token=',
        'TOKEN_TYPE_BEARER' => 'Bearer',
    ],
    'IMAGES' => [
        'MAX_LENGTH' => 30720,   // kb = 30mb
        'DEFAULT' => 'default',
        'THUMBNAIL' => 'thumbnail',
        'URL' => '_url',
        "DEFAULT_TYPE" => ".png"
    ],
    'KEY_GEOCODING_API' => env('KEY_GEOCODING_API'),
    'URL' => [
        'PLACE' => [
            'AUTOCOMPLETE' => 'https://maps.googleapis.com/maps/api/place/autocomplete/json',
            'KEY' => env('KEY_GET_AUTOCOMPLETE_PLACE'),
            'RESPONSE_TYPE' => 'geocode',
            'DETAIL' => 'https://maps.googleapis.com/maps/api/place/details/json',
            'LANGUAGE' => 'ja',
            'REGION' => 'jp',
        ],
        'GEOCODING_URL' => 'https://maps.googleapis.com/maps/api/geocode/json',
    ],
    'MAX_SIZE_VIDEO_INPUT' => 30, //MB
    'KEY' => [
        'VIDEO' => 'video',
        'IMAGE' => 'image'
    ],
    'DATE_DEFAULT' => "12/12/2020",
    'CONVENI' => [
        'SEVEN_ELEVEN' => 0,
        'LAWSON' => 1,
        'FAMILY_MART' => 2,
    ],
    'TYPE_SORT' => [
        'DESCENDING' => 'DESC',
        'ASCENDING' => 'ASC'
    ],
    'DAY_TYPE_PARKING_TIME' => [
        0 => "平日", //weekday
        1 => "土曜日", //Saturday
        2 => "日曜日", //Sunday
        3 => "祝祭日" //Public holidays
    ],

    'DEL_FLG' => [
        'DONE' => 1,
        'WAIT' => 0
    ],

    'RESPONSE_STATUS_OK' => 'OK',

    'DATE_TYPE_PARKING_TIME_API' => [
        'WEEKDAY' => 0,
        'SATURDAY' => 1,
        'SUNDAY' => 2,
        'HOLIDAY' => 3
    ],

    'FULL_WEEKDAY' => 'l', // Shơ full weekday

    'PER_HOUR' => 60,

    'SNS' => [
        'FACEBOOK' => 'Facebook',
        'GOOGLE' => 'Google',
        'LINE' => 'Line',
    ],

    'PAYMENT_TYPE' => [
        'CREDIT_CARD' => 0,
        'COMBINI' => 1,
        'BILL_CORPORATION' => 2
    ],

    'BOOKING_TYPE' => [
        'RENT_BY_MONTH' => 0,
        'RENT_BY_PERIOD' => 1,
        'RENT_BY_HOUR' => 2,
        'RENT_BY_DAY' => 3
    ],

    'CUSTOMER_TYPE' => [
        'INDIVIDUAL' => 0,
        'CORPORATION' => 1,
    ],

    'MONEY_DEFAULT' => 0,

    'STATUS_FLAG_TIME' => [
        'PUBLIC' => 0,
        'PRIVATE' => 1,
        'MONTH' => 2,
        'DATE' => 3,
        'PERIOD' => 4,
        'HOUR' => 5,
    ],

    'STATUS_PERIOD' => [
        'PRIVATE' => 0,
        'PUBLIC' => 1,
    ],

    'DAY_IN_WEEK' => 7,

    'LIMIT_TABLE_ADMIN' => 20,

    "CHECK_DATE_LESS_NOW" => 105,
    "PRICE_ZERO" => 0,
    "CHECK_PRICE_GREATER_ZERO" => 106,
    'SNS_SEARCH' => [
        'ALL' => -1,
        'ID_PASSWORD' => 0,
        'FACEBOOK' => 1,
        'GOOGLE' => 2,
        'LINE' => 3
    ],
    'KUBUN_SEARCH' => [
        'ALL' => -1,
        'PERSONAL' => 0,
        'COMPANY' => 1
    ],
    "CHECK_TIME_FLAG" => 100,
    "CHECK_DATE_FIT" => 101,
    "CHECK_MINIMUM_USE" => 102,
    "CHECK_HOUR_LESS_NOW" => 103,
    "CHECK_WEEKDAY_FIT" => 104,
    'COPYRIGHT' => 'Copyright © Mobilis Consulting Co., Ltd. All Rights Reserved.',
    'LOGO' => '/logo.png',
    'MENU_TIME' => [
        'PRICE_PLACEHOLDER_FORMAT' => 999,
    ],
    'ZIPCOD_PLACEHOLDER' => '9999999',
    'TRANSFER_BEFORE_DATE' => 7,
    'STRING_YYYY/MM/DD' => '/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/',
];
