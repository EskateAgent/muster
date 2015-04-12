<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CharterType extends Model {

  public function charters()
  {
    return $this->hasMany('App\Charter');
  }

}
