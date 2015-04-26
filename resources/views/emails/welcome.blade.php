@extends('emails.base')

@section('content')

  <p>A new account has been created for you on muster.</p>

  <p>Your temporary password is: {{ $password }}, but you will be able to change this once you've logged in.</p>

@endsection
