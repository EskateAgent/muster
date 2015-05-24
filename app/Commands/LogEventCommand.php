<?php namespace App\Commands;

use App\Event;
use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class LogEventCommand extends Command implements SelfHandling {

  protected $user, $operation, $subject;

  /**
   * Create a new command instance.
   *
   * @param  User $user
   * @param  string $operation
   * @param  Object $subject
   * @return void
   */
  public function __construct( \App\User $user, $operation, $subject )
  {
    $this->user = $user;
    $this->operation = $operation;
    $this->subject = $subject;
  }

  /**
   * Execute the command.
   *
   * @return void
   */
  public function handle()
  {
    $event = new Event;
    $event->operation = $this->operation;
    $event->subject_type = get_class( $this->subject );
    $event->subject_id = $this->subject->id;
    $event->user_id = $this->user->id;
    $event->save();
  }

}
