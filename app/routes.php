<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses' => 'HomeController@index'));

/*
 * Routes for UserController
 */

Route::get('/user/login', array('uses' => 'UserController@showLogin'))->before('guest');
Route::post('/user/login', array('uses' => 'UserController@doLogin'))->before('guest');
Route::get('/user/logout', array('uses' => 'UserController@logout'))->before('auth');
Route::get('/user/register', array('uses' => 'UserController@create'))->before('guest');
Route::post('/user/register', array('uses' => 'UserController@create'))->before('guest')->before('csrf');

Route::get('/user/{username}/profile', array('uses' => 'UserController@profile'));
Route::get('/user/{username}/get_twitter_timeline', array('uses' => 'UserController@getTwitterTimeline'));
Route::post('/user/{username}/twitter_timeline_sync/{count}', array('uses' => 'UserController@syncTwitterTimeLine'));
Route::post('/user/{username}/twitter_timeline/toogle', array('uses' => 'UserController@toggle_tweet'));


/*
 * Routes for EntryController
 */
Route::get('/entry/new', array('uses' => 'EntryController@create'))->before('auth');
Route::post('/entry/new', array('uses' => 'EntryController@create'))->before('auth');
Route::get('/entry/{id}/edit', array('uses' => 'EntryController@update'))->before('auth');
Route::post('/entry/{id}/edit', array('uses' => 'EntryController@update'))->before('auth');
Route::get('/entry/{id}/view', array('uses' => 'EntryController@read'));
