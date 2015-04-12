@extends('app')

@section('content')

{!! Form::model( $charter, ['method' => 'PATCH', 'route' => ['leagues.charters.update', $league->slug, $charter->slug ], 'files' => true ] ) !!}
  @include('charters/partials/_form', ['charter' => $charter, 'charter_type_id' => $charter->charter_type_id ] )
{!! Form::close() !!}

@endsection
