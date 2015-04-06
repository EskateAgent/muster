@extends('emails.base')

@section('content')

  A new account has been created for you on muster.

  Your temporary password is: {{ $password }}, but you will be able to change this once you've logged in.

@endsection
