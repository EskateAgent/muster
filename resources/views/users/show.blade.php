@extends('app')

@section('content')
  <div class="page-header {{ $user->isDeleted() ? 'deleted' : '' }}">
    <h1>
      {{ $user->name }}
      {!! Auth::user()->id == $user->id ? '<small>(you)</small>' : '' !!}
      @if( !$user->isDeleted() && Auth::user()->can('user-edit') && ( ( Auth::user()->id == $user->id ) || Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
        <small><a href="{{ route('users.edit', [ $user->id ] ) }}">edit</a></small>
      @endif
    </h1>

    @if( $user->isDeleted() && Auth::user()->can('user-create') )
      {!! Form::model( $user, ['method' => 'patch', 'route' => ['users.restore', $user->id ], 'style' => 'display: inline-block;' ] ) !!}
        {!! Form::submit("Restore this user", ['class' => 'btn btn-success'] ) !!}
      {!! Form::close() !!}
    @else
      @if( $user->id != Auth::user()->id && ( Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
        <form action="/auth/password-reset" method="post">
          {!! Form::hidden('_token', csrf_token() ) !!}
          {!! Form::hidden('user_id', $user->id ) !!}

          {!! Form::submit("Reset user's password", ['class' => 'btn btn-warning', ''] ) !!}
        </form>
      @endif

      @if( $user->id != Auth::user()->id && ( Auth::user()->hasRole('root') || ( Auth::user()->hasRole('staff') && !$user->hasRole('root') ) ) )
        {!! Form::model( $user, ['method' => 'delete', 'route' => ['users.delete', $user->id ] ] ) !!}
          {!! Form::submit('Delete user', ['class' => 'btn btn-danger', ''] ) !!}
        {!! Form::close() !!}
      @endif
    @endif
  </div>
  @if( $user->role() )
    <p>{{ $user->role()->display_name }}</p>
  @endif
  <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
  @if( $user->league )
    <h2>League</h2>
    <p><a href="{{ route('leagues.show', [ $user->league->slug ] ) }}">{{ $user->league->name }}</a></p>
  @endif
@endsection
