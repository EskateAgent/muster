<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

  public function user()
  {
    return $this->hasOne('App\User');
  }

  public function subject()
  {
    $class = $this->subject;
    return $class::findOrFail( $this->subject_id );
  }

  public function canonicalUrl()
  {
    return env('APP_URL') . '/events/' . $this->id;
  }
}
