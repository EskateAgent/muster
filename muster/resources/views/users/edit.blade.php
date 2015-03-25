@extends('app')

@section('content')

{!! Form::model( $user, ['method' => 'PATCH', 'route' => ['users.update', $user->id ] ] ) !!}
  @include('users/partials/_form', ['user' => $user ] )
{!! Form::close() !!}

@endsection
