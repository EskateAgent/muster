@extends('app')

@section('content')
  <h2><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a> - {{ $charter->name }}</h2>
@endsection
