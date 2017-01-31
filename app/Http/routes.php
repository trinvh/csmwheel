<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::controller('search', 'SearchController');

Route::group(['middleware' => 'auth'], function() {
	Route::group(['prefix' => 'event'], function() {
		Route::get('/', 'EventController@getIndex');
		Route::controller('lucky-wheel', 'LuckyWheelController');
	});
	Route::controller('user','UserController');
});

Route::group(['middleware' => 'admin'], function() {
	Route::group(['prefix' => 'admin'], function() {
		Route::controller('user', 'AdminUserController');
		Route::controller('history','AdminHistoryController');
	});
});


Route::controllers([
	'auth' => 'CSMAuthController',
]);

Route::get('install', 'InitController@install');
Route::post('install', 'InitController@modifyDatabase');


