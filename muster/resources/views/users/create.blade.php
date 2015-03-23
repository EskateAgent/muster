@extends('app')

@section('content')

{!! Form::model( new App\User, ['route' => ['users.store'] ] ) !!}
  @include('users/partials/_form')
{!! Form::close() !!}

@endsection
