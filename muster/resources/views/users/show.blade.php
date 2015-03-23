@extends('app')

@section('content')
  <h2>{{ $user->name }} <a href="{{ route('users.edit', [ $user->id ] ) }}">edit</a></h2>
@endsection
