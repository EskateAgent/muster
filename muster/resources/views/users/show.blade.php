@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      {{ $user->name }}
      @if( Auth::user()->can('user-edit') && ( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
        <small><a href="{{ route('users.edit', [ $user->id ] ) }}">edit</a></small>
      @endif
    </h1>
  </div>
  <p>{{ $user->role()->display_name }}</p>
  <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
  @if( $user->league )
    <h2>League</h2>
    <p><a href="{{ route('leagues.show', [ $user->league->slug ] ) }}">{{ $user->league->name }}</a></p>
  @endif
@endsection
