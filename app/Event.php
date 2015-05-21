<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

  public function user()
  {
    return $this->hasOne('App\User');
  }

  public function subject()
  {
    return $this->morphTo()->withTrashed()->first();
  }

  public function canonicalUrl()
  {
    return env('APP_URL') . '/events/' . $this->id;
  }
}
