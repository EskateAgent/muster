<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;
use Route;

class BeforeMiddleware {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle( $request, Closure $next )
  {
    if( is_null( Auth::user() ) && !( $request->is('/') || $request->is('auth/*') ) )
    {
      return redirect()->guest('auth/login');
    }

    return $next( $request );
  }
}
