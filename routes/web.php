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

Route::any('/', 'AdvertsController@index')->name('index');
Route::get('view/{id}', 'AdvertsController@view')->name('view');
Route::get('search/{id}', 'AdvertsController@searchResult')->name('search');

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::prefix('accounts/user')->group(function () {
        Route::get('/{id}/home', 'HomeController@userHome')->name('accounts.user.home');
        Route::get('settings/{id}', 'HomeController@settingsAccounts')->name('accounts.user.settings');
        Route::post('update', 'HomeController@updateAccounts')->name('accounts.user.update');
    });
    Route::prefix('comment')->group(function () {
        Route::post('create', 'CommentsController@create')->name('comment.create');
        Route::get('destroy{id}/{userId}', 'CommentsController@destroy')->name('comment.destroy');
    });
    
    Route::get('destroy/{id}/{user}/{role?}', 'AdvertsController@destroy')->name('destroy');
    Route::post('update', 'AdvertsController@update')->name('update');
    Route::get('edit/{id}', 'AdvertsController@edit')->name('edit');
    Route::post('add', 'AdvertsController@add')->name('add');
    Route::get('create', 'AdvertsController@createAdvert')->name('create');
    Route::post('send-mail', 'MailSetting@sendMessage')->name('emails.contact-mail');
});

Route::middleware(['checkRole:admin', 'auth'])->group(function () {
    Route::prefix('accounts/admin')->group(function () {
        Route::get('/{id}/home', 'HomeController@adminHome')->name('accounts.admin.home');
        Route::get('settings/{id}', 'HomeController@settingsAccounts')->name('accounts.admin.settings');
        Route::any('rubrics', 'AdvertsController@adminRubrics')->name('accounts.admin.rubrics');
        Route::post('update', 'HomeController@updateAccounts')->name('accounts.admin.update');
        Route::get('users', 'HomeController@users')->name('accounts.admin.users');
        Route::get('activate/{id}/{userId}', 'AdvertsController@activate')->name('accounts.admin.activate');
        Route::get('edit/{id}/{userId}', 'HomeController@edit')->name('accounts.admin.edit');
        Route::get('deleteUser/{id}', 'HomeController@deleteUser')->name('accounts.admin.deleteUser');
        Route::any('create', 'HomeController@createUser')->name('accounts.admin.create');
        Route::get('bloked/{id}', 'HomeController@blocked')->name('accounts.admin.blocked');
        Route::get('blokedList', 'HomeController@blokedList')->name('accounts.admin.blokedList');
        Route::get('unBloked/{id}', 'HomeController@unBloked')->name('accounts.admin.unBloked');
    });
});
