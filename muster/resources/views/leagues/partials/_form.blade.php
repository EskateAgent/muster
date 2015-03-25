<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name') !!}
</div>

<div class="form-group">
  {!! Form::label('slug', 'Slug:') !!}
  {!! Form::text('slug') !!}
</div>

<div class="form-group">
  {!! Form::label('user_id', 'User:') !!}
  {!! Form::select('user_id', $league->usersUpForGrabs() ) !!}
</div>


<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn primary'] ) !!}
</div>
