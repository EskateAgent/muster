<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Charter extends Model {

  public function league()
  {
    return $this->belongsTo('App\League');
  }

  public function skaters()
  {
    return $this->hasMany('App\Skater');
  }

}
