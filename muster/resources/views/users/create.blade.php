@extends('app')

@section('content')

{!! Form::model( $user, ['route' => ['users.store'] ] ) !!}
  @include('users/partials/_form', ['user' => $user, 'league_id' => 0 ] )
{!! Form::close() !!}

@endsection
