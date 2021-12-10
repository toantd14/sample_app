<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::get('')
Route::prefix('auth')->group(function () {
    Route::prefix('login')->group(function () {
        Route::post('email', 'AuthController@loginEmail');
        Route::post('facebook', 'AuthController@loginFacebook');
        Route::post('line', 'AuthController@loginLine');
        Route::post('google', 'AuthController@loginGoogle');
    });
});

Route::post('refresh/token', 'AuthController@refresh');
Route::post('use-booking', 'UseSituationController@useBooking');

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('detail', 'UserController@getUserDetail');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'favorite'], function () {
        Route::post('/', 'FavoriteController@favorite');
        Route::get('/', 'ParkingLotController@getListFavorite');
    });

    Route::group(['prefix' => 'parking'], function () {
        Route::post('register', 'UseSituationController@registerParking');
        Route::post('calculate', 'UseSituationController@calculatePriceParking');
        Route::get('latest-token', 'UseSituationController@getLatestToken');
    });

    Route::get('booking-history', 'UseSituationController@getBookingHistory');

    Route::post('review', 'ReviewController@store');
    Route::get('get-review', 'ReviewController@getReview');
    Route::put('review/{id}', 'ReviewController@update');
    Route::get('/pdf-payment/{bookingID}', 'UseSituationController@getLinkDownloadPDFPayment');
    Route::get('/pdf-payment-billing/{bookingID}', 'UseSituationController@getLinkDownloadPDFBill');
});
Route::get('/download-pdf-payment/{bookingID}', 'UseSituationController@downloadPDFPayment')->name('download_pdf_payment');
Route::get('/download-pdf-payment-billing/{bookingID}', 'UseSituationController@downloadPDFBill')->name('download_pdf_payment_billing');

Route::group(['prefix' => 'notification'], function () {
    Route::get('/', 'OwnerNoticeController@getListNotice');
    Route::get('detail/{noticeID}', 'OwnerNoticeController@getDetail');
});

Route::get('contract_template', 'ContractTemplateController@getContractTemplate');

Route::resource('parking_lot', 'ParkingLotController');

Route::resource('review', 'ReviewController');

Route::get('search-zipcode-info', 'GeocodingController@searchZipcodeInfo');

Route::prefix('place')->group(function () {
    Route::get('autocomplete', 'PlaceController@getAutocomplete');
    Route::get('detail', 'PlaceController@getDetail');
});

Route::get('/use_term', 'UseTermController@getUseTerm');

Route::get('question-categories', 'QuestionCategoryController@index');

Route::get('questions', 'QuestionController@getByQuestionCategory');

Route::post('feedback', 'QuestionController@feedback');
