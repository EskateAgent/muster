@extends('app')

@section('content')
  <h2><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a> - {{ $charter->name }}</h2>

  <h3>Skaters</h3>
  @if( !$charter->skaters()->count() )
    <p>{{ $charter->name }} contains no skaters.</p>
  @else
    <ul>
      @foreach( $charter->skaters() as $skater )
        <li>{{ $skater->name }}</li>
      @endforeach
    </ul>
  @endif

@endsection
