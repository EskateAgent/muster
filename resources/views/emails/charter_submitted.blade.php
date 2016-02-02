@extends('emails.base')

@section('content')

  <p>Charter <a href="{{ $charter->canonicalUrl() }}">{{ $charter->name }}</a> belonging to <a href="{{ $charter->league()->canonicalUrl() }}">{{ $charter->league()->name }}</a> has been submitted for approval.</p>

@endsection
