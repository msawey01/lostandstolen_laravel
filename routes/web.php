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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dbview', function() {
  return view('DBcon');
});

Route::get('/authorize', 'AuthController@gettoken');

Route::get('/dbedit', function() {
	return view('DBEdit');
});