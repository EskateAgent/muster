@extends('app')

@section('content')
  <h2>Leagues</h2>
  @if( $user->can('league-create') )
    <a href="{{ route('leagues.create') }}">create new</a>
  @endif

  @if( !$leagues->count() )
    None
  @else
    <ul>
      @foreach( $leagues as $league )
        <li><a href="{{ route('leagues.show', $league->slug) }}">{{ $league->name }}</a></li>
      @endforeach
    </ul>
  @endif
@endsection
