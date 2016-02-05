<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Charter extends Model {

  use SoftDeletes;

  protected $guarded = ['id'];

  protected $dates = ['approved_at', 'approval_requested_at', 'active_from', 'deleted_at', 'effective_from'];

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

  public function replace( array $content )
  {
    if( !( isset( $content['skaters'] ) && count( $content['skaters'] ) ) )
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

    foreach( $content['skaters'] as $skater )
    {
      Skater::create( array_merge( $skater, ['charter_id' => $this->id ] ) );
    }

    if( isset( $content['name'] ) )
    {
      $this->name = $content['name'];
    }

    if( isset( $content['effective_from'] ) )
    {
      $this->effective_from = \Carbon\Carbon::parse( $content['effective_from'] );
    }

    $this->save();
  }

  public function canonicalUrl()
  {
    return $this->league()->canonicalUrl() . '/charters/' . $this->slug;
  }

  public function types()
  {
    $charter_types = [];
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
