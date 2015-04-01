@extends('app')

@section('content')
  <h2>
    {{ $user->name }}
    @if( Auth::user()->can('user-edit') )
      <a href="{{ route('users.edit', [ $user->id ] ) }}">edit</a>
    @endif
  </h2>
  <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
  @if( $user->league )
    <h3>League</h3>
    <p><a href="{{ route('leagues.show', [ $user->league->slug ] ) }}">{{ $user->league->name }}</a></p>
  @endif
@endsection
