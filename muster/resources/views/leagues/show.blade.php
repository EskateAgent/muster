@extends('app')

@section('content')
  <h2>
    {{ $league->name }}
    @if( $user->can('league-edit') )
      <a href="{{ route('leagues.edit', [ $league->slug ] ) }}">edit</a>
    @endif
  </h2>
  @if( $league->user )
  <p>User: <a href="{{ route('users.show', $league->user_id ) }}">{{ $league->user->name }}</a>
  @endif

  <h3>Charters</h3>
  @if( !$league->charters->count() )
    <p>{{ $league->name }} has not submitted any charters.</p>

    @if( $user->can('charter-create') )
      <p><a href="{{ route('leagues.charters.create', [ $league->slug ] ) }}">create new charter</a>
    @endif
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
