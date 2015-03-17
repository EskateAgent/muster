@extends('app')

@section('content')

{!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.update', $league->slug, $charter->slug ] ] ) !!}
  @include('charters/partials/_form')
{!! Form::close() !!}

@endsection
