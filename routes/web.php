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
})->name('welcome');

Auth::routes();

// Change Password Routes
Route::get('change-password', 'Auth\ChangePasswordController@show')->name('password.change');
Route::patch('change-password', 'Auth\ChangePasswordController@update')->name('password.change');

Route::group(['middleware' => ['auth']], function () {
    /*
     * User Dashboard Route
     */
    Route::get('/home', 'DashboardController@index')->name('home');

    /*
     * Groups Routes
     */
    Route::patch('groups/{group}/set-start-date', 'GroupsController@setStartDate')->name('groups.set-start-date');
    Route::patch('groups/{group}/set-end-date', 'GroupsController@setEndDate')->name('groups.set-end-date');
    Route::resource('groups', 'GroupsController');
    Route::resource('groups.meetings', 'Groups\MeetingsController');
    Route::resource('groups.payments', 'Groups\PaymentsController');
    Route::resource('groups.members', 'Groups\MembersController');

    /*
     * Meetings Routes
     */
    Route::get('meetings/{meeting}', 'MeetingsController@show')->name('meetings.show');
    Route::patch('meetings/{meeting}', 'MeetingsController@update')->name('meetings.update');
    Route::post('meetings/{meeting}/payment-entry', 'MeetingsController@paymentEntry')->name('meetings.payment-entry');
    Route::post('meetings/{meeting}/set-winner', 'MeetingsController@setWinner')->name('meetings.set-winner');
});
