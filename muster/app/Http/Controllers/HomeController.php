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
    parent::__construct();
  }

  /**
   * Show the application dashboard to the user.
   *
   * @return Response
   */
  public function index()
  {
    $leagues = \App\League::all();
    return view('home', compact('leagues') );
  }
}
