<?php namespace App\Http\Controllers;

use App\League;
use App\Charter;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ChartersController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @param  League $league
   * @return Response
   */
  public function index( League $league )
  {
    return view('charters.index', compact('league') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create( League $league )
  {
    return view('charters.create', compact('league') );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store( League $league )
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function show( League $league, Charter $charter )
  {
    if( $charter->league != $league )
    {
      // mismatch, what are you doing crazyperson?
    }
    return view('charters.show', compact('league', 'charter') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function edit( League $league, Charter $charter )
  {
    return view('charters.edit', compact('league', 'charter') );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  League $league
   * @return Response
   */
  public function update($id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  League $league
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

}
