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

Route::get('/signin', 'AuthController@signin');

Route::get('/authorize', 'AuthController@gettoken');

Route::get('/dbedit', array('as' => 'dbedit', function() {
  return view('DBEdit');
}));

Route::get('/accessdenied', array('as' => 'accessdenied', function() {
	return view('AccessDenied');
}));

Route::get('/deleteSelected/{ids}', [ 'uses' =>'DBController@deleteItems']);

Route::post('/dbinsert', 'DBController@insertItems');

/*  array('as' => 'deleteSelected', function() {
	return view('DeleteSelected');
}));
 */
#Route::get('/dbedit', 'AuthController.php@printtoken')->name('dbedit');