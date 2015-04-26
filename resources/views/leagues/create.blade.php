@extends('app')

@section('content')
  <div class="page-header">
    <h1>Create new league</h1>
  </div>

  {!! Form::model( new App\League, ['route' => ['leagues.store'] ] ) !!}
    @include('leagues/partials/_form', ['league' => new \App\League, 'user_id' => 0 ] )
  {!! Form::close() !!}
@endsection
