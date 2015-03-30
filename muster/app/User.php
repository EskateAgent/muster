<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword, EntrustUserTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'email', 'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];

  public function league()
  {
    return $this->hasOne('App\League');
  }

  public function leaguesUpForGrabs() // naming things is hard
  {
    $records = \App\League::whereNull('user_id')->orWhere('user_id', '=', $this->id )->orderBy('name', 'asc')->get();
    $leagues = array( 0 => '- none -');
    foreach( $records as $league )
    {
      $leagues[ $league->id ] = $league->name;
    }
    return $leagues;
  }
}
