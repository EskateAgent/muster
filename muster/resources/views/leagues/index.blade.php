@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      All leagues
      @if( Auth::user()->can('league-create') )
        <small><a href="{{ route('leagues.create') }}">create new</a></small>
      @endif
    </h1>
  </div>

  @if( !$leagues->count() )
    <p>None found!</p>
  @else
    <ul>
      @foreach( $leagues as $league )
        <li><a href="{{ route('leagues.show', $league->slug) }}">{{ $league->name }}</a></li>
      @endforeach
    </ul>
  @endif
@endsection
