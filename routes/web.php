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

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::resource('roles', 'RoleController');

Route::resource('users', 'UserController');

Route::get('playbooks/', function() {
    return redirect()->route('entries.index');
});
Route::resource('playbooks/entries', 'Playbooks\EntryController');
Route::resource('playbooks/categories', 'Playbooks\CategoryController');

Route::resource('calendar', 'CalendarController');
