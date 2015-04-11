<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::date('name', \Carbon\Carbon::now() ) !!}
</div>

<div class="form-group">
  {!! Form::label('csv', 'CSV File:') !!}
  {!! Form::file('csv') !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn primary'] ) !!}
</div>
