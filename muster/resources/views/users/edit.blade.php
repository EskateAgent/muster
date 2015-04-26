@extends('app')

@section('content')
  <div class="page-header">
    <h1>Editing {{ $user->name }}</h1>
  </div>

  {!! Form::model( $user, ['method' => 'PATCH', 'route' => ['users.update', $user->id ] ] ) !!}
    @include('users/partials/_form', ['user' => $user, 'league_id' => $league_id ] )
  {!! Form::close() !!}
@endsection
