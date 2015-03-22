@extends('app')

@section('content')
  <h2>{{ $league->name }} <a href="{{ route('leagues.edit', [ $league->slug ] ) }}">edit</a></h2>

  <h3>Charters</h3>
  @if( !$league->charters->count() )
    <p>{{ $league->name }} has not submitted any charters.</p>
    <p><a href="{{ route('leagues.charters.create', [ $league->slug ] ) }}">create new charter</a>
  @else
    @if( $draft = $league->draftCharter() )
      <h4>Draft</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $draft->slug ] ) }}">{{ $draft->name }}</a></p>
    @elseif( $pending = $league->pendingCharter() )
      <h4>Pending</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $pending->slug ] ) }}">{{ $pending->name }}</a></p>
    @endif

    @if( $current = $league->currentCharter() )
      <h4>Current</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $current->slug ] ) }}">{{ $current->name }}</a></p>
    @endif

    @if( $upcoming = $league->upcomingCharter() )
      <h4>Upcoming</h4>
      <p><a href="{{ route('leagues.charters.show', [ $league->slug, $upcoming->slug ] ) }}">{{ $upcoming->name }}</a> (becomes active {{ $upcoming->active_from }})</p>
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
