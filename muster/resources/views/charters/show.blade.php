@extends('app')

@section('content')
  <div class="page-header">
    <h1><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a> - {{ $charter->name }} <small>({{ $charter->charter_type->name }})</small></h1>
  </div>

  @if( !$charter->active_from && ( $reason = $charter->rejection_reason ) )
    <p>Charter submission was rejected: {{ $reason }}</p>
  @endif

  @if( !$charter->active_from && !$charter->approval_requested_at )
    @if( Auth::user()->can('charter-edit') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
      <p><a href="{{ route('leagues.charters.edit', [ $league->slug, $charter->slug ] ) }}">upload a new revision</a></p>
    @endif
    @if( Auth::user()->can('charter-request_approval') && ( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
      <p><a href="{{ route('leagues.charters.request_approval', [ $league->slug, $charter->slug ]) }}">submit this revision for approval</a></p>
    @endif
  @endif

  @if( $charter->approval_requested_at && !$charter->active_from )
    <p>Charter has been submitted for approval</p>

    @if( Auth::user()->can('charter-approve') || Auth::user()->can('charter-reject') )
      <ul class="nav nav-tabs" role="tablist">
        @if( Auth::user()->can('charter-approve') )
          <li><a href="#approve" role="tab" data-toggle="tab">Approve this charter</a></li>
        @endif

        @if( Auth::user()->can('charter-reject') )
          <li><a href="#reject" role="tab" data-toggle="tab">Reject this charter</a></li>
        @endif
      </ul>

      <div class="tab-content">
        @if( Auth::user()->can('charter-approve') )
          <div class="tab-pane" id="approve" style="padding: 20px 0 0;">
            {!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.approve', $league->slug, $charter->slug ] ] ) !!}
              <div class="form-group">
                {!! Form::label('active_from', 'Active From:') !!}
                {!! Form::date('active_from', \Carbon\Carbon::now()->addDays( $league->approvedCharters( $charter->charter_type_id )->count() ? 30 : 0 ), array('class' => 'form-control') ) !!}
              </div>
              <div class="form-group">
                {!! Form::submit('Approve', ['class' => 'btn btn-success'] ) !!}
              </div>
            {!! Form::close() !!}
          </div>
        @endif

        @if( Auth::user()->can('charter-reject') )
          <div class="tab-pane" id="reject" style="padding: 20px 0 0;">
            {!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.reject', $league->slug, $charter->slug ] ] ) !!}
              @if( $charter->rejection_reason )
                <p>This charter was rejected previously, the most recent reason being: {{ $charter->rejection_reason }}</p>
              @endif
              <div class="form-group">
                {!! Form::label('rejection_reason', 'Give a reason for rejection:') !!}
                {!! Form::text('rejection_reason', null, array('class' => 'form-control') ) !!}
              </div>
              <div class="form-group">
                {!! Form::submit('Reject', ['class' => 'btn btn-danger'] ) !!}
              </div>
            {!! Form::close() !!}
          </div>
        @endif
      </div>
    @endif
  @endif

  @if( !$charter->skaters->count() )
    <p>{{ $charter->name }} contains no skaters.</p>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Number</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $charter->skaters as $key => $skater )
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $skater->name }}</td>
            <td>{{ $skater->number }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

@endsection
