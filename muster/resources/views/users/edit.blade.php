@extends('app')

@section('content')

{!! Form::model( $user, ['method' => 'PATCH', 'route' => ['users.update', $user->id ] ] ) !!}
  @include('users/partials/_form', ['user' => $user, 'league_id' => $league_id ] )
{!! Form::close() !!}

@endsection
