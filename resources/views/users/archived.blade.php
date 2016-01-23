@extends('app')

@section('content')
  <div class="page-header">
    <h1>Archived Users</h1>
  </div>

  @if( !$users->count() )
    <p>None found!</p>
  @else
    <ul>
      @foreach( $users as $user )
        <li>
          <a href="{{ route('users.show', $user->id ) }}">{{ $user->name }}</a> - deleted {{ $user->deleted_at }}
        </li>
      @endforeach
    </ul>
  @endif
@endsection
