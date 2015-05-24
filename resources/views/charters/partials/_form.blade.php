@if( !$charter->id )
<div class="form-group">
  {!! Form::label('charter_type_id', 'Type:') !!}
  {!! Form::select('charter_type_id', $charter->types(), $charter_type_id, array('class' => 'form-control') ) !!}
</div>
@endif

<div class="form-group">
  {!! Form::label('csv', 'CSV File:') !!}
  {!! Form::file('csv', array('class' => 'form-control')) !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn btn-primary'] ) !!}
</div>
