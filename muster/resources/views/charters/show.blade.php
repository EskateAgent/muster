@extends('app')

@section('content')
  <h2><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a> - {{ $charter->name }}</h2>
  @if( !$charter->active_from && ( $reason = $charter->rejection_reason ) )
    <p>Charter submission was rejected: {{ $reason }}</p>
  @endif

  @if( !$charter->active_from && !$charter->approval_requested_at )
    <p><a href="{{ route('leagues.charters.edit', [ $league->slug, $charter->slug ] ) }}">upload a new revision</a> or <a href="{{ route('leagues.charters.request_approval', [ $league->slug, $charter->slug ]) }}">submit this revision for approval</a></p>
  @endif

  @if( $charter->approval_requested_at && !$charter->active_from )
    <p>Charter has been submitted for approval</p>

    <p>Approve this charter:</p>
    {!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.approve', $league->slug, $charter->slug ] ] ) !!}
      <div class="form-group">
        {!! Form::label('active_from', 'Active From:') !!}
        {!! Form::date('active_from', \Carbon\Carbon::now()->addDays( count( $league->approvedCharters() ) ? 30 : 0 ) ) !!}
      </div>
      <div class="form-group">
        {!! Form::submit('Approve', ['class' => 'btn primary'] ) !!}
      </div>
    {!! Form::close() !!}

    <p>Or alternatively, reject it instead:</p>
    {!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.reject', $league->slug, $charter->slug ] ] ) !!}
      @if( $charter->rejection_reason )
        <p>This charter was rejected most recently for: {{ $charter->rejection_reason }}</p>
      @endif
      <div class="form-group">
        {!! Form::label('rejection_reason', 'Give a reason for rejection:') !!}
        {!! Form::text('rejection_reason', '') !!}
      </div>
      <div class="form-group">
        {!! Form::submit('Reject', ['class' => 'btn primary'] ) !!}
      </div>
    {!! Form::close() !!}
  @endif

  <h3>Skaters</h3>
  @if( !$charter->skaters->count() )
    <p>{{ $charter->name }} contains no skaters.</p>
  @else
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Number</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach( $charter->skaters as $skater )
          <tr>
            <td>{{ $i }}</td>
            <td>{{ $skater->name }}</td>
            <td>{{ $skater->number }}</td>
          </tr>
        <?php $i++; ?>
        @endforeach
      </tbody>
    </table>
  @endif

@endsection
