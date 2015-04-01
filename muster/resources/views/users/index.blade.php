@extends('app')

@section('content')
  <h2>Users</h2>
  @if( Auth::user()->can('user-create') )
    <a href="{{ route('users.create') }}">create new</a>
  @endif

  @if( !$users->count() )
    None
  @else
    <ul>
      @foreach( $users as $user )
        <li><a href="{{ route('users.show', $user->id ) }}">{{ $user->name }}</a></li>
      @endforeach
    </ul>
  @endif
@endsection
