@extends('app')

@section('content')
  <h2><a href="{{ route('leagues.show', [ $league->slug ] ) }}">{{ $league->name }}</a> - {{ $charter->name }}</h2>
  @if( !$charter->approved_at && !$charter->approval_requested_at )
    <p><a href="{{ route('leagues.charters.edit', [ $league->slug, $charter->slug ] ) }}">upload a new revision</a> or <a href="{{ route('leagues.charters.request_approval', [ $league->slug, $charter->slug ]) }}">submit this revision for approval</a></p>
  @endif

  @if( $charter->approval_requested_at )
    <p>Charter has been submitted for approval</p>
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
