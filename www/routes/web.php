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
 Auth::routes(['register'=>false]);

// Route::get('admin/login/','Admin\AdminController@login')->name('admin.login');
// Route::post('admin/login/','Admin\AdminController@authenticate')->name('admin.authenticate');//->middleware('auth');

Route::resource('client', 'Admin\ClientController')->middleware('auth');
Route::get('data','Admin\ClientController@data')->name('client.data')->middleware('auth');
// Route::get('/home', 'HomeController@index')->name('home');
