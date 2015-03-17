<?php namespace App\Http\Controllers;

use App\League;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;

use Illuminate\Http\Request;

class LeaguesController extends Controller {

  protected $rules = [
    'name' => ['required', 'min:3'],
    'slug' => ['required'],
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

    League::create( Input::all() );
    return Redirect::route('leagues.index')->with('message', 'League created');
  }

  /**
   * Display the specified resource.
   *
   * @param  League $league
   * @return Response
   */
  public function show( League $league )
  {
    return view('leagues.show', compact('league') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  League $league
   * @return Response
   */
  public function edit( League $league )
  {
    return view('leagues.edit', compact('league') );
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
    $this->validate( $request, $this->rules );

    $league->update( array_except( Input::all(), '_method') );
    return Redirect::route('leagues.show', $league->slug )->with('message', 'League updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  League $league
   * @return Response
   */
  public function destroy( League $league )
  {
    //
  }

}
