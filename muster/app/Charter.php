<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Charter extends Model {

  protected $guarded = ['id'];

  public function league()
  {
    return $this->belongsTo('App\League');
  }

  public function skaters()
  {
    return $this->hasMany('App\Skater')->limit(20);
  }

  public function replaceSkaters( array $skaters )
  {
    if( count( $this->skaters ) )
    {
      foreach( $this->skaters as $skater )
      {
        $skater->delete();
      }
    }

    if( count( $skaters ) )
    {
      foreach( $skaters as $skater )
      {
        Skater::create( array_merge( $skater, array('charter_id' => $this->id ) ) );
      }
    }
  }
}
