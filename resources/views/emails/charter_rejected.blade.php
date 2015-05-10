@extends('emails.base')

@section('content')

  <p>Your charter <a href="{{ $charter->canonicalUrl() }}">{{ $charter->name }}</a> has been reviewed and unfortunately it could not be approved by UKRDA Staff.</p>

  <p>The following feedback was given: <em>{{ $charter->rejection_reason }}</em>.</p>

  <p>Please correct any errors and then resubit the charter for approval again.</p>

@endsection
