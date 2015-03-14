@extends('app')

@section('content')
  <h2>{{ $league->name }}</h2>

  <h3>Charters</h3>
  @if( !$league->charters->count() )
    {{ $league->name }} has no charters.
  @else
    <ul>
      @foreach( $league->charters as $charter )
        <li><a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a></li>
      @endforeach
    </ul>
  @endif
@endsection
