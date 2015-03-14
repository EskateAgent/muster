<?php namespace App\Http\Controllers;

use App\League;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LeaguesController extends Controller {

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
   * @return Response
   */
  public function store()
  {
    //
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
   * @return Response
   */
  public function update( League $league )
  {
    //
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
