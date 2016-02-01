<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Skater extends Model {

  protected $fillable = ['name', 'legal_name', 'number', 'charter_id'];

  public function charter()
  {
    return $this->belongsTo('App\Charter');
  }

}
