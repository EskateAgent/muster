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
    return $this->charters()->whereNotNull('approved_at')->orderBy('approved_at', 'desc');
  }

  public function currentCharter()
  {
    return $this->approvedCharters()->first();
  }

  public function draftCharter()
  {
    return $this->charters()->whereNull('approved_at')->first();
  }

  public function historicalCharters()
  {
    return $this->approvedCharters()->take(10)->skip(1)->get();
  }

}
