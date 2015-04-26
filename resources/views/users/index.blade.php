@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      Users
      @if( Auth::user()->can('user-create') )
        <small><a href="{{ route('users.create') }}">create new</a></small>
      @endif
    </h1>
  </div>

  @if( !$users->count() )
    <p>None found!</p>
  @else
    <ul>
      @foreach( $users as $user )
        <li><a href="{{ route('users.show', $user->id ) }}">{{ $user->name }}</a></li>
      @endforeach
    </ul>
  @endif
@endsection
