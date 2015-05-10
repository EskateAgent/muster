@extends('app')

@section('content')
  <div class="page-header">
    <h1>
      {{ $user->name }}
      @if( Auth::user()->can('user-edit') && ( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
        <small><a href="{{ route('users.edit', [ $user->id ] ) }}">edit</a></small>
      @endif
    </h1>

    @if( $user->id != Auth::user()->id && ( Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
      <form action="/auth/password-reset" method="post">
        {!! Form::hidden('_token', csrf_token() ) !!}
        {!! Form::hidden('user_id', $user->id ) !!}

        {!! Form::submit("Reset user's password", ['class' => 'btn btn-danger', ''] ) !!}
      </form>
    @endif
  </div>
  <p>{{ $user->role()->display_name }}</p>
  <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
  @if( $user->league )
    <h2>League</h2>
    <p><a href="{{ route('leagues.show', [ $user->league->slug ] ) }}">{{ $user->league->name }}</a></p>
  @endif
@endsection
