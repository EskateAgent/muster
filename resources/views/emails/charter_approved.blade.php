@extends('emails.base')

@section('content')

  <p>Your charter <a href="{{ $charter->canonicalUrl() }}">{{ $charter->name }}</a> has been reviewed and approved by UKRDA Staff.</p>

  @if( $charter->active_from->isToday() || $charter->active_from->isPast() )
  <p>The charter will take immediate effect as your current charter.</p>
  @else
  <p>The charter will become active on {{ $charter->active_from->toFormattedDateString() }}.</p>
  @endif

@endsection
