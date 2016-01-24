<div class="form-group">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group">
  {!! Form::label('email', 'Email:') !!}
  {!! Form::text('email', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group">
  {!! Form::label('role', 'Role:') !!}
  {!! Form::select('role', $user->rolesUpForGrabs(), $role_id, ['class' => 'form-control'] ) !!}
</div>

@if( $user->hasRole('league') || !$user->id )
  <div class="form-group">
    {!! Form::label('league_id', 'League:') !!}
    {!! Form::select('league_id', $user->leaguesUpForGrabs(), $league_id, ['class' => 'form-control'] ) !!}
  </div>
@endif
<div class="form-group">
  {!! Form::submit('Save', ['class' => 'btn btn-primary'] ) !!}
</div>
