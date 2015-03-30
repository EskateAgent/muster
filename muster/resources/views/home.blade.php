@extends('app')

@section('content')
  <h2>All Leagues</h2>

  @if( !$leagues->count() )
    No leagues
  @else
    <table>
      <thead>
        <tr>
          <th>League</th>
          <th>Charter</th>
          <th>User</th>
        </tr>
      </thead>
      <tbody>
      @foreach( $leagues as $league )
        <tr>
          <td><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a></td>
          <td>
            @if( $charter = $league->currentCharter() )
              <a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a>
            @else
              -
            @endif
          </td>
          <td>
            @if( $user = $league->user )
              <a href="{{ route('users.show', [ $league->user->id ] ) }}">{{ $user->name }}</a>
            @else
              -
            @endif
          </td>
        </tr>
      @endforeach
    </table>
  @endif
@endsection
