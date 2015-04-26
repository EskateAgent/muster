<?php namespace App\Http\Controllers;

use App\League;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Input;
use Redirect;

use Illuminate\Http\Request;
use App\Commands\LogEventCommand;

class LeaguesController extends Controller {

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
    $leagues = League::all();
    return view('leagues.index', compact('leagues') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('leagues.create');
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

    $input = Input::all();
    if( isset( $input['user_id'] ) && !$input['user_id'] )
    {
      unset( $input['user_id'] );
    }

    $league = League::create( $input );

    $this->dispatch( new LogEventCommand( Auth::user(), 'stored', $league ) );

    return Redirect::route('leagues.show', $league->slug )->with('message', 'League has been created');
  }

  /**
   * Display the specified resource.
   *
   * @param  League $league
   * @return Response
   */
  public function show( League $league )
  {
    if( !$league->id )
    {
      abort(404);
    }

    $charter_types = \App\CharterType::all();
    return view('leagues.show', compact('league', 'charter_types') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  League $league
   * @return Response
   */
  public function edit( League $league )
  {
    if( !$league->id )
    {
      abort(404);
    }

    $user_id = !is_null( $league->user_id ) ? $league->user_id : 0;

    if( !( ( Auth::user()->id == $user_id ) || Auth::user()->hasRole('root') || Auth::user()->hasRole('staff') ) )
    {
      abort(404);
    }

    return view('leagues.edit', compact('league', 'user_id') );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  League $league
   * @param  Request $request
   * @return Response
   */
  public function update( League $league, Request $request )
  {
    if( !$league->id )
    {
      abort(404);
    }

    $user_id = !is_null( $league->user_id ) ? $league->user_id : 0;

    if( !( ( Auth::user()->id == $user_id ) || Auth::user()->hasRole('root') || Auth::user()->hasRole('staff') ) )
    {
      abort(404);
    }

    $this->validate( $request, $this->rules );

    $input = Input::all();
    if( isset( $input['user_id'] ) && !$input['user_id'] )
    {
      unset( $input['user_id'] );
    }

    $league->update( array_except( $input, '_method') );

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $league ) );

    return Redirect::route('leagues.show', $league->slug )->with('message', 'League has been updated');
  }
}
