<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

  protected $guarded = ['id'];

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

}
