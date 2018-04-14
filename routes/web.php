<?php

/*
|--------------------------------------------------------------------------
| Webルート
|--------------------------------------------------------------------------
|
| ここでアプリケーションのWebルートを登録できます。"web"ルートは
| ミドルウェアのグループの中へ、RouteServiceProviderによりロード
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'web'], function() {
    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('friend', 'FriendController', ['only' => ['index', 'store']]);

    Route::resource('profile', 'ProfileController', ['only' => ['index', 'store']]);

    Route::resource('room', 'RoomController', ['only' => ['index', 'show']]);

    Route::resource('message', 'MessageController', ['only' => ['show', 'store']]);
    Route::post('message/{id}', 'MessageController@load')->name('message.load');
});
