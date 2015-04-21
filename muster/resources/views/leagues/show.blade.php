@extends('app')

@section('content')
  <h2>
    {{ $league->name }}
    @if( Auth::user()->can('league-edit') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') || Auth::user()->hasRole('staff') ) )
      <small><a href="{{ route('leagues.edit', [ $league->slug ] ) }}">edit</a></small>
    @endif
  </h2>
  @if( $league->user )
    <p>User: <a href="{{ route('users.show', $league->user_id ) }}">{{ $league->user->name }}</a>
  @endif

  <h3>
    Charters
    @if( Auth::user()->can('charter-create') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
      <small><a href="{{ route('leagues.charters.create', [ $league->slug ] ) }}">create new</a></small>
    @endif
  </h3>

  @if( $league->charters->count() )
    @foreach( $charter_types as $type )
      <div class="tab {{ $type }}">
        <h4>{{ $type->name }}</h4>
        @if( $draft = $league->draftCharter( $type->id ) )
          <h5>Draft</h5>
          <p><a href="{{ route('leagues.charters.show', [ $league->slug, $draft->slug ] ) }}">{{ $draft->name }}</a></p>
        @elseif( $pending = $league->pendingCharter( $type->id ) )
          <h5>Pending</h5>
          <p><a href="{{ route('leagues.charters.show', [ $league->slug, $pending->slug ] ) }}">{{ $pending->name }}</a></p>
        @endif

        @if( $current = $league->currentCharter( $type->id ) )
          <h5>Current</h5>
          <p><a href="{{ route('leagues.charters.show', [ $league->slug, $current->slug ] ) }}">{{ $current->name }}</a></p>
        @endif

        @if( $upcoming = $league->upcomingCharter( $type->id ) )
          <h5>Upcoming</h5>
          <p><a href="{{ route('leagues.charters.show', [ $league->slug, $upcoming->slug ] ) }}">{{ $upcoming->name }}</a> (becomes active {{ $upcoming->active_from }})</p>
        @endif

        @if( ( $league->historicalCharters( $type->id )->count() ) )
          <h5>Previous</h5>
          <ul>
            @foreach( $league->historicalCharters() as $charter )
              <li><a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a></li>
            @endforeach
          </ul>
        @endif
      </div>
    @endforeach
  @endif
@endsection
