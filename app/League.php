<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class League extends Model {

  use SoftDeletes;

  protected $guarded = ['id'];

  protected $dates = ['deleted_at'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function events()
  {
    return $this->morphMany('App\Event', 'subject');
  }

  public function charters( $type_id = null )
  {
    $charters = $this->hasMany('App\Charter')->limit(20);
    if( $type_id )
    {
      $charters->where('charter_type_id', '=', $type_id );
    }
    return $charters;
  }

  public function approvedCharters( $type_id = null )
  {
    return $this->charters( $type_id )->whereNotNull('active_from')->orderBy('active_from', 'desc');
  }

  public function currentCharter( $type_id = null )
  {
    return $this->approvedCharters( $type_id )->where('active_from', '<=', Carbon::now() )->first();
  }

  public function draftCharter( $type_id = null )
  {
    return $this->charters( $type_id )->whereNull('active_from')->whereNull('approval_requested_at')->first();
  }

  public function historicalCharters( $type_id = null )
  {
    return $this->approvedCharters( $type_id )->where('active_from', '<=', Carbon::now() )->take(10)->skip(1)->get();
  }

  public function pendingCharter( $type_id = null )
  {
    return $this->charters( $type_id )->whereNull('active_from')->whereNotNull('approval_requested_at')->first();
  }

  public function upcomingCharter( $type_id = null )
  {
    return $this->approvedCharters( $type_id )->where('active_from', '>', Carbon::now() )->first();
  }

  public function countAllCharters()
  {
    return \App\Charter::where('league_id', '=', $this->id )->count();
  }

  public function generateNextCharterName()
  {
    return date('Y') . '-' . strtoupper( explode(' ', $this->name )[0] ) . sprintf("%'.04d", $this->countAllCharters() + 1 );
  }

  public function usersUpForGrabs()
  {
    $leagues = DB::table('leagues')->whereNotNull('user_id')->select('user_id')->get();
    $user_ids = [];
    foreach( $leagues as $league )
    {
      $user_ids[] = $league->user_id;
    }

    $users = [ 0 => '- none -'];

    $query = DB::table('users')->leftJoin('role_user', 'role_user.user_id', '=', 'users.id' )->whereNotIn('users.id', $user_ids )->where('role_user.role_id', '=', 3 );
    if( !is_null( $this->user_id ) )
    {
      $query->orWhere('id', '=', $this->user_id );
    }

    $records = $query->orderBy('name', 'asc')->get();
    foreach( $records as $user )
    {
      if( !$user->deleted_at )
      {
        $users[ $user->id ] = $user->name;
      }
    }
    ksort( $users );
    return $users;
  }

  public function canonicalUrl()
  {
    return env('APP_URL') . '/leagues/' . $this->slug;
  }

  public function isDeleted()
  {
    return !is_null( $this->deleted_at );
  }

  public function removeUser()
  {
    $this->user_id = null;
    return $this->save();
  }
}
