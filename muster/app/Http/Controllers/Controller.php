<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

  use DispatchesCommands, ValidatesRequests;

  /**
   * Construct a new Controller object
   *
   * @return null
   */
  public function __construct()
  {
    $this->beforeFilter( function(){
      \View::share('user', \Auth::user() );
    });
  }
}
