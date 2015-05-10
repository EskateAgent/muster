@extends('emails.base')

@section('content')

  <p>Your password for <a href="{{ env('APP_URL') }}">Muster</a> has been reset by an admin.</p>

  <p>Your new password is: {{ $password }}, but you will be able to change this once you've <a href="{{ env('APP_URL') }}">logged in</a>.</p>

@endsection
