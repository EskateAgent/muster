@extends('app')

@section('content')
  <h2>All Leagues</h2>

  @if( !$leagues->count() )
    No leagues
  @else
    <table>
      <thead>
        <tr>
          <th rowspan="2">League</th>
          <th colspan="{{ count( $charter_types ) }}">Charters</th>
          <th rowspan="2">User</th>
        </tr>
        <tr>
          @foreach( $charter_types as $type )
          <th>{{ $type->name }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
      @foreach( $leagues as $league )
        <tr>
          <td><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a></td>
          @foreach( $charter_types as $type )
          <td>
            @if( $charter = $league->currentCharter( $type->id ) )
              <a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a>
            @else
              -
            @endif
          </td>
          @endforeach
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
