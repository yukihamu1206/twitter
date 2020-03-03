<?php

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#user関連
Route::group(['middleware' => 'auth'],function(){
    Route::resource('users','UsersController',['only' => ['index','show','edit','update']]);
    #tweet関連
    Route::resource('tweets','TweetsController',['ouly' => ['index','create','store','show','edit','update','destroy']]);
    #フォロー関連　
    Route::post('user/{user}/follow','UsersController@follow')->name('follow');
    Route::delete('user/{user}/unfollow','UsersController@unfollow')->name('unfollow');
    #コメント
    Route::resource('comments','CommentsController',['only' => ['store']]);
});


