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
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('/roles', 'RoleController')
    ->only([
        'index',
        'update'
    ])
    ->names([
        'index' => 'roles.index',
        'update' => 'roles.update'
    ]);

Route::resource('/users', 'UserController');