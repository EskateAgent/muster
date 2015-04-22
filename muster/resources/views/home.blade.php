@extends('app')

@section('content')
  <div class="page-header">
    <h1>All Leagues</h1>
  </div>

  @if( !$leagues->count() )
    <p>No leagues</p>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th rowspan="2">League</th>
          <th rowspan="2" style="border-right: 2px solid #ddd">User</th>
          <th colspan="{{ count( $charter_types ) }}" style="text-align: center; border-bottom: 1px solid #ddd;">Current Charters</th>
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
            <td style="border-right: 2px solid #ddd;">
              @if( $user = $league->user )
                <a href="{{ route('users.show', [ $league->user->id ] ) }}">{{ $user->name }}</a>
              @else
                -
              @endif
            </td>
            @foreach( $charter_types as $type )
            <td>
              @if( $charter = $league->currentCharter( $type->id ) )
                <a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a>
              @else
                -
              @endif
            </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
