<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class League extends Model {

  protected $guarded = ['id'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function charters()
  {
    return $this->hasMany('App\Charter')->limit(20);
  }

  public function approvedCharters()
  {
    return $this->charters()->whereNotNull('active_from')->orderBy('active_from', 'desc');
  }

  public function currentCharter( $type_id = null )
  {
    $charters = $this->approvedCharters()->where('active_from', '<=', date('c') );
    if( $type_id )
    {
      $charters->where('charter_type_id', '=', $type_id );
    }
    return $charters->first();
  }

  public function draftCharter()
  {
    return $this->charters()->whereNull('active_from')->whereNull('approval_requested_at')->first();
  }

  public function historicalCharters()
  {
    return $this->approvedCharters()->where('active_from', '<=', date('c') )->take(10)->skip(1)->get();
  }

  public function pendingCharter()
  {
    return $this->charters()->whereNull('active_from')->whereNotNull('approval_requested_at')->first();
  }

  public function upcomingCharter()
  {
    return $this->approvedCharters()->where('active_from', '>', date('c') )->first();
  }

  public function usersUpForGrabs()
  {
    $leagues = DB::table('leagues')->whereNotNull('user_id')->select('user_id')->get();
    $user_ids = array();
    foreach( $leagues as $league )
    {
      $user_ids[] = $league->user_id;
    }

    $users = array( 0 => '- none -');

    $query = DB::table('users')->whereNotIn('id', $user_ids );
    if( !is_null( $this->user_id ) )
    {
      $query->orWhere('id', '=', $this->user_id );
    }

    $records = $query->orderBy('name', 'asc')->get();

    foreach( $records as $user )
    {
      $users[ $user->id ] = $user->name;
    }
    ksort( $users );
    return $users;
  }
}
