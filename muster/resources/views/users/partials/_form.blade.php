<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name') !!}
</div>

<div class="form-group">
  {!! Form::label('email', 'Email:') !!}
  {!! Form::text('email') !!}
</div>

<div class="form-group">
  {!! Form::label('league_id', 'League:') !!}
  {!! Form::number('league_id') !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn primary'] ) !!}
</div>
