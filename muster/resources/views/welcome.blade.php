@extends('app')

@section('content')
  <h2>Current League Charters</h2>

  @if( !$leagues->count() )
    No leagues
  @else
    <ul>
      @foreach( $leagues as $league )
        <li>
          {{ $league->name }}:
          @if( $charter = $league->currentCharter() )
            <a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a>
          @else
            none
          @endif
        </li>
      @endforeach
    </ul>
  @endif
@endsection
