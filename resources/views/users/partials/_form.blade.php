<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name', null, array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
  {!! Form::label('email', 'Email:') !!}
  {!! Form::text('email', null, array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
  {!! Form::label('role', 'Role:') !!}
  {!! Form::select('role', $user->rolesUpForGrabs(), $role_id, array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
  {!! Form::label('league_id', 'League:') !!}
  {!! Form::select('league_id', $user->leaguesUpForGrabs(), $league_id, array('class' => 'form-control') ) !!}
</div>

<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn btn-primary'] ) !!}
</div>
