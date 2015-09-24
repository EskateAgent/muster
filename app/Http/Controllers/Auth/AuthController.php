<?php namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Input;
use Redirect;
use App\Commands\LogEventCommand;
use Validator;

class AuthController extends Controller {

  /*
  |--------------------------------------------------------------------------
  | Registration & Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users, as well as the
  | authentication of existing users. By default, this controller uses
  | a simple trait to add these behaviors. Why don't you explore it?
  |
  */

  use AuthenticatesAndRegistersUsers;

  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest', ['except' => ['getLogout', 'getPasswordChange', 'postPasswordChange', 'postPasswordReset'] ] );
  }

  /**
   * Handle a login request to the application.
   * Overloads AuthenticatesAndRegistersUsers::postLogin()
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function postLogin(Request $request)
  {
    $this->validate( $request, ['email' => 'required|email', 'password' => 'required'] );
    $credentials = $request->only('email', 'password');

    if( Auth::attempt( $credentials, $request->has('remember') ) )
    {
      $user = Auth::user();
      if( is_null( $user->last_login ) )
      {
        return redirect('auth/password-change');
      }

      $user->last_login = \Carbon\Carbon::now();
      $user->save();

      return redirect()->intended( $this->redirectPath() );
    }

    return redirect( $this->loginPath() )
            ->withInput( $request->only('email', 'remember') )
            ->withErrors( ['email' => $this->getFailedLoginMessage() ] );
  }

  public function getPasswordChange( Request $request )
  {
    return view('auth.password-change');
  }

  public function postPasswordChange( Request $request )
  {
    $user = Auth::user();
    if( !Auth::validate( ['email' => $user->email, 'password' => $request->input('current') ] ) )
    {
      return redirect('/auth/password-change')
              ->withErrors( ['current' => 'Your password could not be changed - current password not recognised.'] );
    }

    if( $request->input('new') != $request->input('repeat') )
    {
      return redirect('/auth/password-change')
              ->withErrors( ['new' => 'Your password could not be changed - passwords did not match.'] );
    }

    if( strlen( $request->input('new') ) < 8 )
    {
      return redirect('/auth/password-change')
              ->withErrors( ['new' => 'Your password could not be changed - password must be at least 8 characters long.'] );
    }

    $user->password = \Hash::make( $request->input('new') );
    $user->save();

    return redirect('/home')->withMessage('Your password has been changed.');
  }

  public function postPasswordReset( Request $request )
  {
    $user = User::findOrFail( $request->input('user_id') );

    if( !( Auth::user()->hasRole('root') || Auth::user()->hasRole('staff') ) )
    {
      abort(404);
    }

    $password = User::generateTemporaryPassword();
    $user->password = \Hash::make( $password );

    $user->save();

    $this->dispatch( new LogEventCommand( Auth::user(), 'reset-password', $user ) );

    \Mail::send('emails.password-reset', ['name' => $user->name, 'password' => $password ], function( $message )use( $user ){
      $message->to( $user->email, $user->name )->subject('Your Password Has Been Reset');
    });

    return Redirect::route('users.show', $user->id )->with('message', "User's password has been reset and emailed to them.");
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  public function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return User
   */
  public function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
    ]);
  }
}
