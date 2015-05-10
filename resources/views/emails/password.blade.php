@extends('emails.base')

@section('content')

  <p>A request to reset your password on <a href="{{ env('APP_URL') }}">Muster</a> has been received.</p>

  <p>If this was you, please click here to continue the resetting process: {{ url('password/reset/' . $token ) }}</p>

  <p>If you did not request this password reset, please reply immediately to let the administrators know that something funky has happened!</p>

@endsection
