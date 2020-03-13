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

Route::get('/tweets','ApiController@tweets');
Route::get('/tweets/{tweet}','ApiController@tweet_get');
Route::post('/tweet','ApiController@tweet_post')->middleware('auth:api');

