@extends('app')

@section('content')
  <h2>{{ $league->name }}</h2>
  <a href="{{ route('leagues.edit', [ $league->slug ] ) }}">edit</a>

  <h3>Charters</h3>
  <p><a href="{{ route('leagues.charters.create', [ $league->slug ] ) }}">create new</a>
  @if( !$league->charters->count() )
    {{ $league->name }} has not submitted any charters.
  @else
    @if( $draft = $league->draftCharter() )
      <h4>Draft</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $draft->slug ] ) }}">{{ $draft->name }}</a></p>
    @endif

    @if( $current = $league->currentCharter() )
      <h4>Current</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $current->slug ] ) }}">{{ $current->name }}</a></p>
    @endif

    @if( ( $league->historicalCharters()->count() ) )
      <h4>Previous</h4>
      <ul>
        @foreach( $league->historicalCharters() as $charter )
          <li><a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a></li>
        @endforeach
      </ul>
    @endif
  @endif
@endsection
