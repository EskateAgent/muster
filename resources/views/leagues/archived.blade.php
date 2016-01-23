@extends('app')

@section('content')
  <div class="page-header">
    <h1>Archived leagues</h1>
  </div>

  @if( !$leagues->count() )
    <p>None found!</p>
  @else
    <ul>
      @foreach( $leagues as $league )
        <li><a href="{{ route('leagues.show', $league->slug) }}">{{ $league->name }}</a> - deleted {{ $league->deleted_at }}</li>
      @endforeach
    </ul>
  @endif
@endsection
