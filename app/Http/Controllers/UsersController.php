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
   * Display a listing of archived (deleted) resources.
   *
   * @return Response
   */
  public function archived()
  {
    if( !Auth::user()->can('user-archived') )
    {
      return Redirect::route('users.index')->with('error', 'Page could not be found.');
    }

    $users = User::onlyTrashed()->get();
    return view('users.archived', compact('users') );
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
        return Redirect::route('users.index')->with('error', $league->name . ' already has a user!');
      }
    }

    $this->validate( $request, $this->rules );

    $user = User::create( Input::all() );
    $password = User::generateTemporaryPassword();
    $user->password = \Hash::make( $password );

    $user->save();

    if( $role = $request->input('role') )
    {
      if( $role < Auth::user()->role()->id )
      {
        return Redirect::route('users.index')->with('error', 'You cannot create a user with these permissions.');
      }
      $user->roles()->sync([ $role ]);
    }

    if( isset( $league ) && !$league->user && $user->hasRole('league') )
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
   * @param  int $id
   * @return Response
   */
  public function show( $id )
  {
    $user = User::withTrashed()->where('id', $id )->first();

    if( !$user || ( $user->isDeleted() && !Auth::user()->can('user-delete') ) )
    {
      return Redirect::route('users.index')->with('error', 'User could not be found.');
    }

    return view('users.show', compact('user') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return Response
   */
  public function edit( $id )
  {
    $user = User::where('id', $id )->first();

    if( !$user )
    {
      return Redirect::route('users.index')->with('error', 'User could not be found');
    }

    if( !( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
    {
      return Redirect::route('users.index')->with('error', 'You cannot edit this user.');
    }

    $league_id = !is_null( $user->league ) ? $user->league->id : 0;
    $role_id = $user->role()->id;
    return view('users.edit', compact('user', 'league_id', 'role_id') );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int $id
   * @param  Request $request
   * @return Response
   */
  public function update( $id, Request $request )
  {
    $user = User::where('id', $id )->first();

    if( !$user )
    {
      return Redirect::route('users.index')->with('error', 'User could not be found');
    }

    if( !( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
    {
      return Redirect::route('users.index')->with('error', 'You cannot edit this user.');
    }

    $input = Input::all();
    $remove_league = false;
    if( isset( $input['league_id'] ) )
    {
      if( !$input['league_id'] || ( $input['role'] < 3 ) )
      {
        $remove_league = true;
      }
      else
      {
        $league = \App\League::find( $input['league_id'] );
        if( $league->user && ( $league->user_id != $user->id ) )
        {
          Redirect::route('users.index')->with('message', $league->name . ' already has a user!');
        }
      }
    }

    $this->validate( $request, $this->rules );
    $user->update( array_except( $input, ['_method', 'league_id'] ) );

    if( $role = $input['role'] )
    {
      if( $role < Auth::user()->role()->id )
      {
        return Redirect::route('users.index')->with('error', 'You cannot edit this user.');
      }
      $user->roles()->sync([ $role ]);
    }

    if( isset( $league ) && !$league->user )
    {
      $league->user_id = $user->id;
      $league->save();
    }
    else if( $remove_league && $user->league )
    {
      $user->league->removeUser();
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $user ) );

    return Redirect::route('users.show', $user->id )->with('message', 'User has been updated');
  }

  /**
   * Soft delete the specified resource from storage.
   *
   * @param  int $id
   * @return Response
   */
  public function delete( $id )
  {
    $user = User::where('id', $id )->first();

    if( !$user || $user->isDeleted() )
    {
      return Redirect::route('users.index')->with('error', 'User could not be found.');
    }

    if( ( Auth::user()->hasRole('staff') && $user->hasRole('root') ) || Auth::user()->hasRole('league') )
    {
      return Redirect::route('users.index')->with('error', 'You cannot delete this user.');
    }

    if( $user->league )
    {
      $user->league->removeUser();
    }

    $user->delete();
    $this->dispatch( new LogEventCommand( Auth::user(), 'deleted', $user ) );

    return Redirect::route('users.index')->with('message', 'User ' . $user->name . ' has been deleted');
  }

  /**
   * Restore the specified resource from having been soft-deleted
   *
   * @param  int $id
   * @return Response
   */
  public function restore( $id )
  {
    $user = User::onlyTrashed()->where('id', $id )->first();

    if( !Auth::user()->can('user-create') || !$user->isDeleted() )
    {
      return Redirect::route('users.index')->with('error', 'You cannot restore this user.');
    }

    $user->restore();
    $user->roles()->sync([ 3 ]); // force to be league user

    $this->dispatch( new LogEventCommand( Auth::user(), 'restored', $user ) );

    return Redirect::route('users.show', [ $user->id ] )->with('message', 'User has been restored');
  }
}
