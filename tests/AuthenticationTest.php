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

  public function testUnauthenticatedLeagues()
  {
    $response = $this->call('GET', '/leagues');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('auth/login');
  }

  public function testAuthenticatedHome()
  {
    $this->be( $this->users['league'] );

    $response = $this->call('GET', '/');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('home');
  }

  public function testRestrictedRoute()
  {
    $response = $this->call('GET', '/events');
    $this->assertEquals( 302, $response->getStatusCode() );
    $this->assertRedirectedTo('auth/login');

    $this->be( $this->users['league'] );
    $response = $this->call('GET', '/events');
    $this->assertEquals( 403, $response->getStatusCode() );

    $this->be( $this->users['staff'] );
    $response = $this->call('GET', '/events');
    $this->assertEquals( 403, $response->getStatusCode() );

    $this->be( $this->users['root'] );
    $response = $this->call('GET', '/events');
    $this->assertEquals( 200, $response->getStatusCode() );
  }
}
