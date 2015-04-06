@extends('emails.base')

@section('content')

  Click here to reset your password: {{ url('password/reset/' . $token ) }}

@endsection
