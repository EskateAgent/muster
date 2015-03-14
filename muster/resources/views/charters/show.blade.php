@extends('app')

@section('content')
  <h2><a href="{{ route('leagues.show', [$league->slug]) }}">{{ $league->name }}</a> - {{ $charter->created_at }}</h2>
@endsection
