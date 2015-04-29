@extends('app')

@section('content')
  <div class="page-header">
    <h1>Audit Log</h1>
  </div>

  @if( !$events->count() )
    <p>None found!</p>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Who?</th>
          <th>Did What?</th>
          <th>To What?</th>
          <th>When?</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $events as $event )
          <?php $user = \App\User::findOrFail( $event->user_id );?>
          <tr>
            <td><a href="{{ route('users.show', [ $user->id ] ) }}">{{ $user->name }}</a></td>
            <td>{{ str_replace('-', ' ', $event->operation ) }}</td>
            <td>
              <?php
                $subject = $event->subject();
                switch( get_class( $subject ) )
                {
                  case 'App\Charter':
                    $route = route('leagues.charters.show', [ $subject->league->slug, $subject->slug ] );
                    break;

                  case 'App\League':
                    $route = route('leagues.show', [ $subject->slug ] );
                    break;

                  case 'App\User':
                    $route = route('users.show', [ $subject->id ] );
                    break;

                  default:
                    d( get_class( $subject ) );

                }
              ?>
              <a href="{{ $route }}">{{ $subject->name }}</a>
            </td>
            <td>{{ $event->created_at }}</td>
          </tr>
        @endforeach
      </tbody>
    </ul>
  @endif
@endsection
