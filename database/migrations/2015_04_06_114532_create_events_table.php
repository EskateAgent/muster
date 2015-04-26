<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('events', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('user_id')->unsigned()->default(0);
      $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
      $table->string('operation');
      $table->string('subject');
      $table->integer('subject_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('events');
  }

}
