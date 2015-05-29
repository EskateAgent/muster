<?php

use App\Role;
use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

  protected $users = array();

  /**
   * Creates the application.
   *
   * @return \Illuminate\Foundation\Application
   */
  public function createApplication()
  {
    $app = require __DIR__.'/../bootstrap/app.php';

    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    return $app;
  }

  /**
   * Sets up some user objects for use with auth checks
   *
   * @return null
   */
  public function setUp()
  {
    parent::setUp();

    $root = new User(['name' => 'test root user', 'email' => 'root@test.test']);
    $root->roles[] = Role::find(1);

    $staff = new User(['name' => 'test staff user', 'email' => 'staff@test.test']);
    $staff->roles[] = Role::find(2);

    $league = new User(['name' => 'test league user', 'email' => 'league@test.test']);
    $league->roles[] = Role::find(3);

    $this->users = array(
                         'root'   => $root,
                         'staff'  => $staff,
                         'league' => $league,
                         );
  }
}
