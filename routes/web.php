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

Route::get('/{lang?}', 'HomeController@index');
Route::get('/{lang?}/events', 'HomeController@EventsMuslim');
Route::get('/{lang?}/map', 'HomeController@Map');
Route::get('/{lang?}/calendar', 'HomeController@Calendar');
Route::get('/{lang?}/azkar', 'HomeController@Azkar');
Route::get('/{lang?}/prayer', 'HomeController@Prayer');
Route::get('/{lang?}/weather', 'HomeController@Weather');
Route::get('/getAzkar/{id}', 'HomeController@getAzkar');
Route::get('/getip', 'HomeController@GetIP');
Route::get('/lan/islamicEvent', 'HomeController@getIslamicEvents');
Route::get('/getPrayerTimes/{lat}/{lng}/{date}', 'HomeController@getPrayerTimes');

Route::get('/set/sitemap',"HomeController@SiteMap");
