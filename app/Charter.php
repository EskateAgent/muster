<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Charter extends Model {

  use SoftDeletes;

  protected $guarded = ['id'];

  protected $dates = ['approved_at', 'approval_requested_at', 'active_from', 'deleted_at'];

  public function league()
  {
    return League::withTrashed()->where('id', $this->league_id )->first();
  }

  public function events()
  {
    return $this->morphMany('App\Event', 'subject');
  }

  public function charter_type()
  {
    return $this->belongsTo('App\CharterType');
  }

  public function skaters()
  {
    return $this->hasMany('App\Skater')->limit(20)->orderBy('number');
  }

  public function replaceSkaters( array $skaters )
  {
    if( !count( $skaters ) )
    {
      throw new Exception('No skaters found!');
    }

    if( count( $this->skaters ) )
    {
      foreach( $this->skaters as $skater )
      {
        $skater->delete();
      }
    }

    foreach( $skaters as $skater )
    {
      Skater::create( array_merge( $skater, array('charter_id' => $this->id ) ) );
    }
  }

  public function canonicalUrl()
  {
    return $this->league->canonicalUrl() . '/charters/' . $this->slug;
  }

  public function types()
  {
    $charter_types = array();
    foreach( \App\CharterType::all() as $charter_type )
    {
      $charter_types[ $charter_type->id ] = $charter_type->name;
    }
    return $charter_types;
  }

  public function isDeleted()
  {
    return !is_null( $this->deleted_at );
  }
}
