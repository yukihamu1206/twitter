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

//Route::middleware('auth:api'){
//
//});
// Route::resource('/tweets','TweetsController',['only' => ['index','create','store','show','edit','update','destroy']])->middleware('auth:api');

Route::get('/tweets','ApiController@tweets')->middleware('auth:api');
Route::post('/tweet','ApiController@tweet_post')->middleware('auth:api');
Route::get('/tweets/{tweet}','ApiController@tweet_get')->middleware('auth:api');

