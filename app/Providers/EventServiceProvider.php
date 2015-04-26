<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Str;

class EventServiceProvider extends ServiceProvider {

  /**
   * The event handler mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    'event.name' => [
      'EventListener',
    ],
  ];

  /**
   * Register any other events for your application.
   *
   * @param  \Illuminate\Contracts\Events\Dispatcher  $events
   * @return void
   */
  public function boot(DispatcherContract $events)
  {
    parent::boot($events);

    \App\Charter::saving( function( $charter ){ $charter->slug = $this->generateSlug( $charter ); });
    \App\League::saving( function( $league ){ $league->slug = $this->generateSlug( $league ); });
  }

  protected function generateSlug( $object )
  {
    $class = get_class( $object );
    $slug = Str::slug( $object->name );

    if( $object->slug && ( $object->slug == $slug ) )
    {
      return $object->slug;
    }

    $count = $class::whereRaw('slug RLIKE "^' . $slug . '(-[0-9]+)?$"')->count();
    return $slug . ( $count ? '-' . $count : '' );
  }
}
