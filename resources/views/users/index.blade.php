@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      Users
      @if( Auth::user()->can('user-create') )
        <small><a href="{{ route('users.create') }}">create new</a></small>
      @endif
      @if( Auth::user()->can('user-archived') )
        @if( Auth::user()->can('user-create') )
        <small>&bullet;</small>
        @endif
        <small><a href="{{ route('users.archived') }}">archived</a></small>
      @endif
    </h1>
  </div>

  @if( !$users->count() )
    <p>None found!</p>
  @else
    <ul>
      @foreach( $users as $user )
        <li>
          <a href="{{ route('users.show', $user->id ) }}">{{ $user->name }}</a>
          @if( $user->league )
          - <a href="{{ route('leagues.show', $user->league_id ) }}">{{ $user->league->name }}</a>
          @endif
        </li>
      @endforeach
    </ul>
  @endif
@endsection
