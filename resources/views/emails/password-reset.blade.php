@extends('emails.base')

@section('content')

  <p>Your password for muster has been reset by an admin.</p>

  <p>Your new password is: {{ $password }}, but you will be able to change this once you've logged in.</p>

@endsection
