<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::date('name', \Carbon\Carbon::now() ) !!}
</div>

<div class="form-group">
  {!! Form::label('charter_type_id', 'Type:') !!}
  {!! Form::select('charter_type_id', $charter->types(), $charter_type_id ) !!}
</div>

<div class="form-group">
  {!! Form::label('csv', 'CSV File:') !!}
  {!! Form::file('csv') !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn primary'] ) !!}
</div>
