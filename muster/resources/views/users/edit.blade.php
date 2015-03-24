@extends('app')

@section('content')

{!! Form::model( $user, ['method' => 'PATCH', 'route' => ['users.update', $user->id ] ] ) !!}
  @include('users/partials/_form')
{!! Form::close() !!}

@endsection
