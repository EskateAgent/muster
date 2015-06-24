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

<br /><br />
<aside>
  <span class="icon info"></span>
  <p>If you're not sure what format your <abbr title="Comma-separated value">CSV</abbr> file needs to be in, have a look at this <a href="/assets/example.csv">example file</a> as a starting point.</p>
  <p>As long as your CSV matches the same columns as the example file, we'll do our best to convert that into a meaningful charter.</p>
  <p>&nbsp;</p>
  <p>Incidentally, if your league is WFTDA-affiliated, then you can also use the CSV files which Mothership exports without any modification!</p>
</aside>
