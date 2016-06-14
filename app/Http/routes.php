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

Route::post('users', ['as' => 'users.store', 'uses' => 'UsersController@store']);
Route::get('users', ['as' => 'users.index', 'uses' => 'UsersController@index']);
Route::get('users/create', ['as' => 'users.create', 'uses' => 'UsersController@create']);
Route::get('users/archived', ['as' => 'users.archived', 'uses' => 'UsersController@archived']);
Route::delete('users/{user}', ['as' => 'users.delete', 'uses' => 'UsersController@delete']);
Route::get('users/{user}', ['as' => 'users.show', 'uses' => 'UsersController@show']);
Route::put('users/{user}', ['as' => 'users.update', 'uses' => 'UsersController@update']);
Route::patch('users/{user}', ['as' => 'users.update', 'uses' => 'UsersController@update']);
Route::get('users/{user}/edit', ['as' => 'users.edit', 'uses' => 'UsersController@edit']);
Route::patch('users/{user}/restore', ['as' => 'users.restore', 'uses' => 'UsersController@restore']);

Route::post('leagues', ['as' => 'leagues.store', 'uses' => 'LeaguesController@store']);
Route::get('leagues', ['as' => 'leagues.index', 'uses' => 'LeaguesController@index']);
Route::get('leagues/create', ['as' => 'leagues.create', 'uses' => 'LeaguesController@create']);
Route::get('leagues/archived', ['as' => 'leagues.archived', 'uses' => 'LeaguesController@archived']);
Route::delete('leagues/{league}', ['as' => 'leagues.delete', 'uses' => 'LeaguesController@delete']);
Route::get('leagues/{league}', ['as' => 'leagues.show', 'uses' => 'LeaguesController@show']);
Route::put('leagues/{league}', ['as' => 'leagues.update', 'uses' => 'LeaguesController@update']);
Route::patch('leagues/{league}', ['as' => 'leagues.update', 'uses' => 'LeaguesController@update']);
Route::get('leagues/{league}/edit', ['as' => 'leagues.edit', 'uses' => 'LeaguesController@edit']);
Route::patch('leagues/{league}/restore', ['as' => 'leagues.restore', 'uses' => 'LeaguesController@restore']);

Route::post('leagues/{league}/charters', ['as' => 'leagues.charters.store', 'uses' => 'ChartersController@store']);
Route::get('leagues/{league}/charters/create', ['as' => 'leagues.charters.create', 'uses' => 'ChartersController@create']);
Route::delete('leagues/{league}/charters/{charter}', ['as' => 'leagues.charters.delete', 'uses' => 'ChartersController@delete']);
Route::get('leagues/{league}/charters/{charter}', ['as' => 'leagues.charters.show', 'uses' => 'ChartersController@show']);
Route::put('leagues/{league}/charters/{charter}', ['as' => 'leagues.charters.update', 'uses' => 'ChartersController@update']);
Route::patch('leagues/{league}/charters/{charter}', ['as' => 'leagues.charters.update', 'uses' => 'ChartersController@update']);
Route::get('leagues/{league}/charters/{charter}/edit', ['as' => 'leagues.charters.edit', 'uses' => 'ChartersController@edit']);
Route::patch('leagues/{league}/charters/{charter}/request-approval', ['as' => 'leagues.charters.request_approval', 'uses' => 'ChartersController@requestApproval']);
Route::patch('leagues/{league}/charters/{charter}/approve', ['as' => 'leagues.charters.approve', 'uses' => 'ChartersController@approve']);
Route::patch('leagues/{league}/charters/{charter}/reject', ['as' => 'leagues.charters.reject', 'uses' => 'ChartersController@reject']);

Route::resource('events', 'EventsController');

Route::controllers([
  'auth'     => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);

Route::get('clear-cache', function(){
  $instructions = ['auth:clear-resets', 'cache:clear', 'config:clear', 'clear-compiled', 'view:clear', 'config:cache', 'optimize'];
  $results = [];
  foreach( $instructions as $instruction )
  {
    $results[ $instruction ] = Artisan::call( $instruction );
  }
  printf('<pre>%s</pre>', var_export( $results, 1 ) );
  die;
});

Route::get('migrate', function(){
  $result = Artisan::call('migrate');
  printf('<pre>%s</pre>', var_export( $result, 1 ) );
  die;
});

// Role-based permissions
Entrust::routeNeedsPermission('home', 'home');

Entrust::routeNeedsPermission('users*', 'user-show');
Entrust::routeNeedsPermission('users/create', 'user-create');
Entrust::routeNeedsPermission('users/store', 'user-create');
Entrust::routeNeedsPermission('users/*/edit', 'user-edit');
Entrust::routeNeedsPermission('users/*/update', 'user-edit');
Entrust::routeNeedsPermission('users/*/delete', 'user-delete');
Entrust::routeNeedsPermission('users/*/restore', 'user-create');

Entrust::routeNeedsPermission('leagues*', 'league-show');
Entrust::routeNeedsPermission('leagues/create', 'league-create');
Entrust::routeNeedsPermission('leagues/store', 'league-create');
Entrust::routeNeedsPermission('leagues/*/edit', 'league-edit');
Entrust::routeNeedsPermission('leagues/*/update', 'league-edit');
Entrust::routeNeedsPermission('leagues/*/delete', 'league-delete');
Entrust::routeNeedsPermission('leagues/*/restore', 'league-create');

Entrust::routeNeedsPermission('leagues/*/charters*', 'charter-show');
Entrust::routeNeedsPermission('leagues/*/charters/create', 'charter-create');
Entrust::routeNeedsPermission('leagues/*/charters/store', 'charter-create');
Entrust::routeNeedsPermission('leagues/*/charters/*/edit', 'charter-edit');
Entrust::routeNeedsPermission('leagues/*/charters/*/update', 'charter-edit');
Entrust::routeNeedsPermission('leagues/*/charters/*/delete', 'charter-delete');
Entrust::routeNeedsPermission('leagues/*/charters/*/request-approval', 'charter-request_approval');
Entrust::routeNeedsPermission('leagues/*/charters/*/approve', 'charter-approve');
Entrust::routeNeedsPermission('leagues/*/charters/*/reject', 'charter-reject');

Entrust::routeNeedsPermission('events*', 'event-show');
