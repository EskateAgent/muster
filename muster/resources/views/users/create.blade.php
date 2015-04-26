@extends('app')

@section('content')
  <div class="page-header">
    <h1>Create new user</h1>
  </div>

  {!! Form::model( $user, ['route' => ['users.store'] ] ) !!}
    @include('users/partials/_form', ['user' => $user, 'league_id' => 0 ] )
  {!! Form::close() !!}
@endsection
