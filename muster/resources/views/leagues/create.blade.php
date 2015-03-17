@extends('app')

@section('content')

{!! Form::model( new App\League, ['route' => ['leagues.store'] ] ) !!}
  @include('leagues/partials/_form')
{!! Form::close() !!}

@endsection
