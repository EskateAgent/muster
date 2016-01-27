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
    $leagues = League::all()->sortBy('name');
    return view('leagues.index', compact('leagues') );
  }

  /**
   * Display a listing of archived (deleted) resources.
   *
   * @return Response
   */
  public function archived()
  {
    if( !Auth::user()->can('league-archived') )
    {
      abort(404);
    }

    $leagues = League::onlyTrashed()->get();
    return view('leagues.archived', compact('leagues') );
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
  public function show( $slug )
  {
    $league = League::withTrashed()->where('slug', $slug )->first();

    if( !$league->id || ( $league->isDeleted() && !Auth::user()->can('league-delete') ) )
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
  public function edit( $slug )
  {
    $league = League::where('slug', $slug )->first();

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
  public function update( $slug, Request $request )
  {
    $league = League::where('slug', $slug )->first();

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
    $remove_user = false;
    if( isset( $input['user_id'] ) && !$input['user_id'] )
    {
      $remove_user = true;
      unset( $input['user_id'] );
    }

    $league->update( array_except( $input, '_method') );

    if( $remove_user )
    {
      $league->user_id = null;
      $league->save();
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $league ) );

    return Redirect::route('leagues.show', $league->slug )->with('message', 'League has been updated');
  }

  /**
   * Soft delete the specified resource from storage.
   *
   * @param  League $league
   * @return Response
   */
  public function delete( $slug )
  {
    $league = League::where('slug', $slug )->first();

    if( !$league->id || !Auth::user()->can('league-delete') || $league->isDeleted() )
    {
      abort(404);
    }

    if( !is_null( $league->user_id ) )
    {
      $league->user_id = null;
      $league->save();
    }

    $league->delete();
    $this->dispatch( new LogEventCommand( Auth::user(), 'deleted', $league ) );

    return Redirect::route('leagues.show', [ $league->slug ] )->with('message', 'League has been deleted');
  }

  /**
   * Restore the specified resource from having been soft-deleted
   *
   * @param  String $slug
   * @return Response
   */
  public function restore( $slug )
  {
    $league = League::onlyTrashed()->whereSlug( $slug )->first();

    if( !$league->id || !Auth::user()->can('league-create') || !$league->isDeleted() )
    {
      abort(404);
    }

    $league->restore();
    $this->dispatch( new LogEventCommand( Auth::user(), 'restored', $league ) );

    return Redirect::route('leagues.show', [ $league->slug ] )->with('message', 'League has been restored');
  }
}
