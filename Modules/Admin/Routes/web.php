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
    Route::get('/admin/login', 'AuthController@index')->name('get.admin.login');
    Route::post('/admin/login', 'AuthController@doLogin')->name('do.admin.login');
});

Route::get('/admin/logout', 'AuthController@logout')->name('get.admin.logout');
Route::prefix('admin')->middleware(['check.admin'])->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/owner-banks/{owner}/create', 'OwnerBankController@create')->name('owner-banks.create');
    Route::get('owner-banks/{id}/edit', 'OwnerBankController@editOrUpdate')->name('owner-banks.edit');
    Route::post('owner-banks/{id}/update', 'OwnerBankController@updateOrCreate')->name('owner-banks.update');
    Route::get('/owner-password/{owner}/create', 'OwnerPasswordController@create')->name('owner-password.create');
    Route::get('owner-password/{id}/edit', 'OwnerPasswordController@edit')->name('owner-password.edit');
    Route::post('owner-password/{id}/update', 'OwnerPasswordController@updateOrCreate')->name('owner-password.update');
    Route::resource('/owners', 'OwnerController')->only(['create', 'update']);
    Route::get('owners/{owner}/edit', 'OwnerController@edit')->name('owners.edit');
    Route::post('owners/store', 'OwnerController@store')->name('owners.store');
    Route::get('owners', 'OwnerController@index')->name('owners.index');
    Route::post('owners', 'OwnerController@index')->name('owners.search');
    Route::get('users', 'UserController@index')->name('users.list');
    Route::get('users/search', 'UserController@index')->name('users.search');
    Route::get('users/{id}/edit', 'UserController@edit')->name('get.users.edit');
    Route::put('users/{id}/update', 'UserController@update')->name('post.users.edit');
    Route::get('parkings/search', 'ParkingController@searchParking')->name('search.parking');
    Route::resource('parkings','ParkingController');
    Route::resource('parking-spaces','ParkingSpaceController');
    Route::get('use-situations/search', 'UseSituationController@search')->name('use-situations.search');
    Route::get('use-situations/export', 'UseSituationController@exportCSV')->name('admin.export.use.situation');
    Route::resource('use-situations', 'UseSituationController')->only(['index', 'show']);
    Route::get('parkings/create-space-parking/{parkingCd}', 'ParkingController@createSpaceParking')->name('parking.create_space_parking');
    Route::post('menus-admin/time/create-or-update', 'MenuController@createOrUpdateMenuTime')->name('menus-admin.time.create_or_update');
    Route::post('menus-admin/period/create-or-update', 'MenuController@createOrUpdateMenuPeriod')->name('menus-admin.period.create_or_update');
    Route::post('update-menu-flg', 'MenuController@updateMenuFlg')->name('menus.update_menu_flg');
    Route::prefix('menus-admin')->group(function () {
        Route::post('/period/create-or-update', 'MenuController@createOrUpdateMenuPeriod')->name('menus-admin.period.create_or_update');
        Route::post('month/create-or-update', 'MenuController@createOrUpdateMenuMonth')->name('menus-admin.month.create_or_update');
        Route::post('day/create-or-update', 'MenuController@createOrUpdateMenuDay')->name('menus-admin.day.create_or_update');
        Route::post('period/create-or-update', 'MenuController@createOrUpdateMenuPeriod')->name('menus-admin.period.create_or_update');
        Route::post('update-menu-flg', 'MenuController@updateMenuFlg')->name('menus-admin.update_menu_flg');
        Route::post('time/create-or-update', 'MenuController@createOrUpdateMenuTime')->name('menus-admin.time.create_or_update');
    });

    Route::get('get-flg-owner/{ownerCD}', 'OwnerController@getFlgOwner')->name('admin.get_flg_owner');
});
