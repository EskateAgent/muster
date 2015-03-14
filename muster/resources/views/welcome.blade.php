@extends('app')

@section('content')
  <h2>Current League Charters</h2>

  @if( !$leagues->count() )
    No leagues
  @else
    <ul>
      @foreach( $leagues as $league )
        <li>
          <a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a>:
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
