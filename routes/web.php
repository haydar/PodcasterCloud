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

Route::get('/feeds/{podcastSlug}', 'FeedController@getFeed')->name('feed');

Route::group(['prefix'=>'manage','middleware' => 'auth'], function() {

    Route::get('/', 'PodcastController@index');

    Route::resource('podcast', 'PodcastController');

    Route::resource('user', 'UserController')->except(['create', 'show', 'store']);

    Route::get('users/{id}/podcast/{slug}','UserController@show')->name('user.show');

    Route::resource('podcast.episode', 'EpisodeController')->except(['edit']);

    Route::post('/podcast/{podcast}/episode/upload','EpisodeController@uploadEpisodeAudioFile')->name('podcast.episode.upload');

    Route::post('/podcast/{podcast}/episode/search','EpisodeController@search')->name('podcast.episode.search');

    Route::put('user/{id}/updateAvatar', 'UserController@updateAvatar')->name('user.updateAvatar');

});
