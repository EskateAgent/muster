<?php namespace App\Http\Controllers;

class HomeController extends Controller {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard to the user.
   *
   * @return Response
   */
  public function index()
  {
    $leagues = \App\League::all()->sortBy('name');
    $charter_types = \App\CharterType::all();
    return view('home', compact('leagues', 'charter_types') );
  }
}
