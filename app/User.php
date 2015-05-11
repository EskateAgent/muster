<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword, EntrustUserTrait, SoftDeletes;

  protected $dates = ['deleted_at'];

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

  public function events()
  {
    return $this->hasMany('App\Event');
  }

  public function role()
  {
    return $this->roles()->first();
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

  public function rolesUpForGrabs()
  {
    $records = \App\Role::where('id','>=', \Auth::user()->role()->id )->orderBy('display_name', 'asc')->get();
    $roles = array();
    foreach( $records as $role )
    {
      $roles[ $role->id ] = $role->display_name;
    }
    return $roles;
  }

  public static function generateTemporaryPassword()
  {
    return substr( str_shuffle( md5( microtime() ) ), 0, 12 );
  }

  public function canonicalUrl()
  {
    return env('APP_URL') . '/users/' . $this->id;
  }
}
