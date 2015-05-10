@extends('emails.base')

@section('content')

  <p>A new account has been created for you on <a href="{{ env('APP_URL') }}">Muster</a>.</p>

  <p>Your temporary password is: {{ $password }}, but you will be able to change this once you've <a href="{{ env('APP_URL') }}">logged in</a>.</p>

@endsection
