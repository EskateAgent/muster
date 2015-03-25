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

  public function currentCharter()
  {
    return $this->approvedCharters()->where('active_from', '<=', date('c') )->first();
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
    $records = DB::table('users')->whereNotIn('id', $user_ids )->orderBy('name', 'asc')->get();
    foreach( $records as $user )
    {
      $users[ $user->id ] = $user->name;
    }
    return $users;
  }
}
