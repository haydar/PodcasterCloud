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

Auth::routes();

Route::get('/verify','UserVerificationController@verify')->name('user.verifyEmail');
Route::get('/resend','UserVerificationController@resend')->name('user.resendVerificationEmail');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'manage','middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('dashboard.pages.home');
    });
    Route::post('user','UserController@index');
    Route::resource('user', 'UserController')->except(['create', 'store']);
    Route::post('user/{id}/updateAvatar', 'UserController@postUpdateAvatar')->name('user.updateAvatar');
    Route::resource('podcast', 'PodcastController');
});
