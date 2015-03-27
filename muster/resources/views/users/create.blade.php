@extends('app')

@section('content')

{!! Form::model( $user, ['route' => ['users.store'] ] ) !!}
  @include('users/partials/_form', ['user' => $user ] )
{!! Form::close() !!}

@endsection
