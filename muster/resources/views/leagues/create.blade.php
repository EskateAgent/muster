@extends('app')

@section('content')

{!! Form::model( new App\League, ['route' => ['leagues.store'] ] ) !!}
  @include('leagues/partials/_form', ['league' => new \App\League, 'user_id' => 0 ] )
{!! Form::close() !!}

@endsection
