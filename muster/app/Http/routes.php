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

Route::model('users', 'User');
Route::resource('users', 'UsersController');
Route::bind('users', function( $id ){
  return App\User::whereId( $id )->first();
});

Route::model('leagues', 'League');
Route::resource('leagues', 'LeaguesController');
Route::bind('leagues', function( $slug ){
  return App\League::whereSlug( $slug )->first();
});

Route::model('leagues.charters', 'Charter');
Route::resource('leagues.charters', 'ChartersController');
Route::bind('charters', function( $slug ){
  return App\Charter::whereSlug( $slug )->first();
});
Route::get('leagues/{league}/charters/{charter}/request-approval', [
  'as'   => 'leagues.charters.request_approval',
  'uses' => 'ChartersController@requestApproval',
]);
Route::patch('leagues/{league}/charters/{charter}/approve', [
  'as'   => 'leagues.charters.approve',
  'uses' => 'ChartersController@approve',
]);
Route::patch('leagues/{league}/charters/{charter}/reject', [
  'as'   => 'leagues.charters.reject',
  'uses' => 'ChartersController@reject',
]);

Route::controllers([
  'auth'     => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);


// Role-based permissions
Entrust::routeNeedsPermission('home', 'home');

Entrust::routeNeedsPermission('users/create', 'user-create');
Entrust::routeNeedsPermission('users/store', 'user-create');
Entrust::routeNeedsPermission('users/*', 'user-show');
Entrust::routeNeedsPermission('users/*/edit', 'user-edit');
Entrust::routeNeedsPermission('users/*/update', 'user-edit');
Entrust::routeNeedsPermission('users/*/destroy', 'user-destroy');

Entrust::routeNeedsPermission('leagues/create', 'league-create');
Entrust::routeNeedsPermission('leagues/store', 'league-create');
Entrust::routeNeedsPermission('leagues/*', 'league-show');
Entrust::routeNeedsPermission('leagues/*/edit', 'league-edit');
Entrust::routeNeedsPermission('leagues/*/update', 'league-edit');
Entrust::routeNeedsPermission('leagues/*/destroy', 'league-destroy');

Entrust::routeNeedsPermission('leagues/*/charters/create', 'charter-create');
Entrust::routeNeedsPermission('leagues/*/charters/store', 'charter-create');
Entrust::routeNeedsPermission('leagues/*/charters/*', 'charter-show');
Entrust::routeNeedsPermission('leagues/*/charters/*/edit', 'charter-edit');
Entrust::routeNeedsPermission('leagues/*/charters/*/update', 'charter-edit');
Entrust::routeNeedsPermission('leagues/*/charters/*/destroy', 'charter-destroy');
Entrust::routeNeedsPermission('leagues/*/charters/*/request-approval', 'charter-request_approval');
Entrust::routeNeedsPermission('leagues/*/charters/*/approve', 'charter-approve');
Entrust::routeNeedsPermission('leagues/*/charters/*/reject', 'charter-reject');
