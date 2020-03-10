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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#user関連
Route::group(['middleware' => 'auth'],function(){
    Route::get('/','TweetsController@index');
    Route::resource('users','UsersController',['only' => ['index','show','edit','update']]);
    #tweet関連
    Route::resource('tweets','TweetsController',['ouly' => ['index','create','store','show','edit','update','destroy']]);
    #フォロー関連　
    Route::post('user/{user}/follow','UsersController@follow')->name('follow');
    Route::delete('user/{user}/unfollow','UsersController@unfollow')->name('unfollow');
    #コメント
    Route::resource('comments','CommentsController',['only' => ['store']]);
    #いいね
    Route::resource('favorites','FavoritesController',['only' => ['store','destroy']]);
});

//// ログインURL
//Route::get('auth/twitter', 'Auth\TwitterController@redirectToProvider');
//// コールバックURL
//Route::get('auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
//// ログアウトURL
//Route::get('auth/twitter/logout', 'Auth\TwitterController@logout');

