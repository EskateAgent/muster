<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Skater extends Model {

  public function charter()
  {
    return $this->belongsTo('App\Charter');
  }

}
