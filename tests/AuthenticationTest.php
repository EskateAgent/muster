<?php

class AuthenticationTest extends TestCase {

  public function testUnauthenticatedHome()
  {
    $response = $this->call('GET', '/');
    $this->assertEquals( 200, $response->getStatusCode() );

    $response = $this->call('GET', '/home');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('auth/login');
  }

  public function testAuthenticatedHome()
  {
    $user = new \App\User(['name' => 'test user']);

    $this->be( $user );

    $response = $this->call('GET', '/');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('home');
  }

  public function testUnauthenticatedLeagues()
  {
    $response = $this->call('GET', '/leagues');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('auth/login');
  }
}
