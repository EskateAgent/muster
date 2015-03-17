@extends('app')

@section('content')

{!! Form::model( new App\Charter, ['route' => ['leagues.charters.store', $league->slug ] ] ) !!}
  @include('charters/partials/_form')
{!! Form::close() !!}

@endsection
