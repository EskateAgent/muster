<?php

  $pictures = array(
                    array('name' => 'duckling.jpg', 'description' => 'a quizzical duckling'),
                    array('name' => 'elephant.jpg', 'description' => 'a very happy elephant'),
                    array('name' => 'flamingo.jpg', 'description' => 'an awkward, baby flamingo'),
                    array('name' => 'glass.jpg', 'description' => 'a snifter of kitty'),
                    array('name' => 'kitten.jpg', 'description' => 'a teeny tiny kitten'),
                    array('name' => 'owls.jpg', 'description' => 'some kissing owls'),
                    array('name' => 'panda.jpg', 'description' => 'a panda'),
                    array('name' => 'puppies.jpg', 'description' => 'a stack of cute puppies'),
                    array('name' => 'puppy.jpg', 'description' => 'a puppy munching a shoe'),
                    array('name' => 'rabbits.jpg', 'description' => 'kissing rabbits'),
                    array('name' => 'red-pandas.jpg', 'description' => 'high-fiving red pandas'),
                    array('name' => 'tiger.jpg', 'description' => 'an unimpressed tiger'),
                    array('name' => 'zebra.jpg', 'description' => 'a frolicking zebra foal'),
  );

  $selected = array_rand( $pictures );

?>

@extends('app')

@section('content')
  <div class="page-header">
    <h1>Oh dear!</h1>
  </div>
  <p>We've looked around and can't find the thing you're looking for.</p>
  <p>Sorry about that.</p>
  <p>&nbsp;</p>
  <p>Perhaps this picture of {{ $pictures[ $selected ]['description'] }} will make you feel better?</p>
  <p><img src="/images/404/{{ $pictures[ $selected ]['name'] }}" alt="{{ $pictures[ $selected ]['description'] }}" /></p>
@endsection
