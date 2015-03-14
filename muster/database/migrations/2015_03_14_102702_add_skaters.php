<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkaters extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skaters', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('charter_id')->unsigned()->default(0);
      $table->foreign('charter_id')->references('id')->on('charters')->onDelete('cascade');
      $table->string('name')->default('');
      $table->string('number', 4 )->default('');
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
    Schema::drop('skaters');
  }

}
