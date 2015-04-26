@extends('app')

@section('content')
  <div class="page-header">
    <h1>Create new charter</h1>
  </div>

  {!! Form::model( new App\Charter, ['route' => ['leagues.charters.store', $league->slug ], 'files' => true ] ) !!}
    @include('charters/partials/_form', ['charter' => new App\Charter, 'charter_type_id' => null ] )
  {!! Form::close() !!}
@endsection
