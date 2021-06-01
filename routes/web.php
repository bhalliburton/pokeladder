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


// Authentication routes
Auth::routes();


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
	Route::get('conflictinggames', 'ConflictingGames@index')->name('conflictinggames');
});

// Include Wave Routes
Wave::routes();

Route::get('leaderboard', 'LeaderBoard@index')->name('leaderboard')->middleware('wave');

Route::get('history', 'RecentGames@index')->name('history')->middleware('wave');

Route::get('/history/{username}', 'RecentGames@api');

Route::get('startgame/{format}/{bo}', 'StartGame@index')->name('startgame')->middleware('wave');

Route::get('viewgame', 'StartGame@view')->name('viewgame')->middleware('wave');

Route::get('cancelgame', 'CancelGame@index')->name('cancelgame')->middleware('wave');

Route::get('acceptgame', 'AcceptGame@index')->name('acceptgame')->middleware('wave');

Route::get('refusegame', 'RefuseGame@index')->name('refusegame')->middleware('wave');

Route::get('wongame/{state}', 'WonGame@index')->name('wongame')->middleware('wave');


