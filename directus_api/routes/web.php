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

//use App\Http\Middleware\CheckUrl;

Route::get('/', function () {
    return view('welcome');
});

//News Route
//Route::get(env('APP_BASEURL') . '/news', 'pageController@getApiData');
/*
Route::prefix(env('APP_BASEURL'))->group(function () {
    Route::get('/news', 'pageController@showAllNews');
    Route::get('/news/{id?}', 'pageController@showNewsById')->where(['id' => '[0-9]+']);
    Route::get('/news/{slug?}', 'pageController@showNewsBySlug');
});
*/

Route::get('/news', 'pageController@showAllNews');
Route::get('/news/{id?}', 'pageController@showNewsById')->where(['id' => '[0-9]+']);
Route::get('/news/{slug?}', 'pageController@showNewsBySlug');
