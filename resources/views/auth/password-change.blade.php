@extends('app')

@section('content')
  <div class="page-header">
    <h1>Changing password for {{ Auth::user()->name }}</h1>
  </div>

  <form action="/auth/password-change" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
      {!! Form::label('current', 'Current password:') !!}
      {!! Form::password('current', array('class' => 'form-control') ) !!}
    </div>

    <div class="form-group">
      {!! Form::label('new', 'New password:') !!}
      {!! Form::password('new', array('class' => 'form-control') ) !!}
    </div>

    <div class="form-group">
      {!! Form::label('repeat', 'Repeat:') !!}
      {!! Form::password('repeat', array('class' => 'form-control') ) !!}
    </div>

    <div class="form-group">
      {!! Form::submit('Save', ['class' => 'btn btn-primary'] ) !!}
    </div>
  </form>

@endsection
