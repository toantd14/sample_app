<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', 'AuthController@showLogin')->name('get.owner.login');
    Route::post('/login', 'AuthController@doLogin')->name('do.owner.login');
    Route::get('register', 'AuthController@getRegister')->name('member.get.register');
    Route::post('register', 'AuthController@postRegister')->name('member.post.register');
    Route::get('/set-password', 'AuthController@getSetPassword')->name('member.get.set.password')->middleware('check.set.password');
    Route::post('/set-password', 'AuthController@doSetPassword')->name('member.do.set.password');
});
Route::get('/owner/logout', 'AuthController@logout')->name('get.owner.logout');
Route::prefix('owner')->middleware(['check.login'])->group(function () {
    Route::get('/', 'TopController@index');
    Route::resource('member', 'OwnerController')->except(['index', 'store', 'destroy']);
    Route::resource('users', 'UserController');
    Route::resource('bank-info', 'OwnerBankController')->except(['index', 'destroy', 'create', 'edit']);
    Route::resource('change-password', 'OwnerPassController')->only(['edit', 'update']);
    Route::resource('verify', 'VerifyController');
    Route::put('update-menu-parking/{menuParkingId}', 'ParkingLotController@updateMenuParking')->name('update.menu.parking');
    Route::get('parkinglot/get-by-code', 'ParkingLotController@getByCode')->name('parkinglot.get_by_code');
    Route::get('parkinglot/create-slot-parking/{parkingCd}', 'ParkingLotController@createSlotParking')->name('parkinglot.create_slot_parking');
    Route::resource('parkinglot', 'ParkingLotController');
    Route::resource('slots-parking', 'SlotParkingController');
    Route::resource('top', 'TopController');
    Route::get('notifications-search', 'NotificationController@searchNotice')->name('search.notice');
    Route::resource('notifications', 'NotificationController');
    Route::prefix('menus')->group(function () {
        Route::post('month/create-or-update', 'MenuController@createOrUpdateMenuMonth')->name('menus.month.create_or_update');
        Route::post('day/create-or-update', 'MenuController@createOrUpdateMenuDay')->name('menus.day.create_or_update');
        Route::post('period/create-or-update', 'MenuController@createOrUpdateMenuPeriod')->name('menus.period.create_or_update');
        Route::post('update-menu-flg', 'MenuController@updateMenuFlg')->name('menus.update_menu_flg');
        Route::post('time/create-or-update', 'MenuController@createOrUpdateMenuTime')->name('menus.time.create_or_update');
        Route::put('time/edit/{id}', 'MenuController@editTime')->name('menus.time.edit');
    });
    Route::resource('menus', 'MenuController');
    Route::get('time-used/search', 'UseSituationController@search')->name('search.use.situation');
    Route::resource('time-used', 'UseSituationController');
    Route::get('use-situation/export', 'UseSituationController@exportCSV')->name('export.use.situation');
});

Route::resource('user', 'UserController');
