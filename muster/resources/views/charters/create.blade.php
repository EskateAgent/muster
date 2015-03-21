@extends('app')

@section('content')

{!! Form::model( new App\Charter, ['route' => ['leagues.charters.store', $league->slug ], 'files' => true ] ) !!}
  @include('charters/partials/_form')
{!! Form::close() !!}

@endsection
