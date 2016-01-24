<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group">
  {!! Form::label('user_id', 'User:') !!}
  {!! Form::select('user_id', $league->usersUpForGrabs(), $user_id, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn btn-primary'] ) !!}
</div>
