<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');

Route::model('leagues', 'League');
Route::resource('leagues', 'LeaguesController');
Route::bind('leagues', function( $value, $route ){
  return App\League::whereSlug( $value )->first();
});

Route::model('leagues.charters', 'Charter');
Route::resource('leagues.charters', 'ChartersController');

Route::controllers([
  'auth'     => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);
