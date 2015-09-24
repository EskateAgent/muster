<?php

use App\Role;
use App\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

  protected $users = array();

  protected $baseUrl = 'http://localhost';

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

    $this->users = array(
                          'root'   => new User(['name' => 'test root user', 'email' => 'root@test.test']),
                          'staff'  => new User(['name' => 'test staff user', 'email' => 'staff@test.test']),
                          'league' => new User(['name' => 'test league user', 'email' => 'league@test.test']),
                        );

    $this->users['root']->roles[] = Role::find(1);
    $this->users['staff']->roles[] = Role::find(2);
    $this->users['league']->roles[] = Role::find(3);
  }
}
