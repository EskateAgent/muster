@extends('app')

@section('content')

{!! Form::model( $league, ['method' => 'PATCH', 'route' => ['leagues.update', $league->slug] ] ) !!}
  @include('leagues/partials/_form')
{!! Form::close() !!}

@endsection
