<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Input;
use Redirect;

use Illuminate\Http\Request;
use App\Commands\LogEventCommand;

class UsersController extends Controller {

  protected $rules = [
    'name' => ['required', 'min:3'],
  ];

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $users = User::all();
    return view('users.index', compact('users') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $user = new User;
    $role_id = null;
    return view('users.create', compact('user', 'role_id') );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  Request $request
   * @return Response
   */
  public function store( Request $request )
  {
    if( $league_id = $request->input('league_id') )
    {
      $league = \App\League::find( $league_id );
      if( $league->user && ( $league->user_id != $user->id ) )
      {
        Redirect::route('users.index')->with('message', $league->name . ' already has a user!');
      }
    }

    $this->validate( $request, $this->rules );

    $user = User::create( Input::all() );

    $password = $this->generateTemporaryPassword();
    $user->password = \Hash::make( $password );

    $user->save();

    if( $role = $request->input('role') )
    {
      $user->roles()->sync([ $role ]);
    }

    if( isset( $league ) && !$league->user )
    {
      $league->user_id = $user->id;
      $league->save();
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'stored', $user ) );

    \Mail::send('emails.welcome', ['name' => $user->name, 'password' => $password ], function( $message )use( $user ){
      $message->to( $user->email, $user->name )->subject('Welcome!');
    });

    return Redirect::route('users.show', $user->id )->with('message', 'User has been created');
  }

  /**
   * Display the specified resource.
   *
   * @param  User $user
   * @return Response
   */
  public function show( User $user )
  {
    return view('users.show', compact('user') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  User $user
   * @return Response
   */
  public function edit( User $user )
  {
    if( !( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
    {
      \App::abort(403);
    }

    $league_id = !is_null( $user->league ) ? $user->league->id : 0;
    $role_id = $user->roles()->first()->id;
    return view('users.edit', compact('user', 'league_id', 'role_id') );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  User $user
   * @param  Request $request
   * @return Response
   */
  public function update( User $user, Request $request )
  {
    if( !( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
    {
      \App::abort(403);
    }

    if( $league_id = $request->input('league_id') )
    {
      $league = \App\League::find( $league_id );
      if( $league->user && ( $league->user_id != $user->id ) )
      {
        Redirect::route('users.index')->with('message', $league->name . ' already has a user!');
      }
    }

    $this->validate( $request, $this->rules );
    $user->update( array_except( Input::all(), array('_method', 'league_id') ) );

    if( $role = $request->input('role') )
    {
      $user->roles()->sync([ $role ]);
    }

    if( isset( $league ) && !$league->user )
    {
      $league->user_id = $user->id;
      $league->save();
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $user ) );

    return Redirect::route('users.show', $user->id )->with('message', 'User has been updated');
  }

  protected function generateTemporaryPassword()
  {
    return substr( str_shuffle( md5( microtime() ) ), 0, 8 );
  }
}
