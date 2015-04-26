@extends('app')

@section('content')
  <div class="page-header">
    <h1>Editing {{ $league->name }}</h1>
  </div>

  {!! Form::model( $league, ['method' => 'PATCH', 'route' => ['leagues.update', $league->slug ] ] ) !!}
    @include('leagues/partials/_form', ['user_id' => $user_id ] )
  {!! Form::close() !!}
@endsection
