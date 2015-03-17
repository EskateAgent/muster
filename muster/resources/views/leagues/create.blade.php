@extends('app')

@section('content')

{!! Form::open(array('url' => 'foo/bar')) !!}
  //
{!! Form::close() !!}

@endsection
