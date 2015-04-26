@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      {{ $league->name }}
      @if( Auth::user()->can('league-edit') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') || Auth::user()->hasRole('staff') ) )
        <small><a href="{{ route('leagues.edit', [ $league->slug ] ) }}">edit</a></small>
      @endif
    </h1>
  </div>

  @if( $league->user )
    <p>User: <a href="{{ route('users.show', $league->user_id ) }}">{{ $league->user->name }}</a>
  @endif

  <h2>
    Charters
    @if( Auth::user()->can('charter-create') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
      <small><a href="{{ route('leagues.charters.create', [ $league->slug ] ) }}">create new</a></small>
    @endif
  </h2>

  @if( $league->charters->count() )
    <ul class="nav nav-tabs" role="tablist">
      @foreach( $charter_types as $key => $type )
        <li class="{{ $key == 0 ? 'active' : '' }}"><a href="#{{ strtolower( $type->name ) }}" role="tab" data-toggle="tab">{{ $type->name }}</a></li>
      @endforeach
    </ul>

    <div class="tab-content">
      @foreach( $charter_types as $key => $type )
        @include('leagues/partials/_tab', ['league' => $league, 'type' => $type, 'key' => $key ] )
      @endforeach
    </div>
  @endif
@endsection