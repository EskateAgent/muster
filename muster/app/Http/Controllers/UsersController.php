<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;

use Illuminate\Http\Request;

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
    $users = League::all();
    return view('users.index', compact('users') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('users.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  Request $request
   * @return Response
   */
  public function store( Request $request )
  {
    $this->validate( $request, $this->rules );

    $user = User::create( Input::all() );
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
    return view('users.edit', compact('user') );
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
    $this->validate( $request, $this->rules );

    $league->update( array_except( Input::all(), '_method') );
    return Redirect::route('users.show', $user->id )->with('message', 'User has been updated');
  }

}