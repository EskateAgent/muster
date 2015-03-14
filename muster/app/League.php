<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

  public function charters()
  {
    return $this->hasMany('App\Charter');
  }

  public function approvedCharters()
  {
    return $this->charters()->whereNotNull('approved_at')->orderBy('approved_at', 'desc');
  }

  public function currentCharter()
  {
    return $this->approvedCharters->first();
  }

  public function historicalCharters()
  {
    return $this->approvedCharters()->take(100)->skip(1)->get();
  }

}
