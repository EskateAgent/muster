@extends('emails.base')

@section('content')

  <p>A new charter for {{ $charter->league->name }} has been submitted for approval.</p>

  <p>You can view the charter by visting this link: <a href="{{ $charter_url }}">{{ $charter_url }}</a>.</p>

@endsection
