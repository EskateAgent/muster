<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCharters extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('charters', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('league_id')->unsigned()->default(0);
      $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
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
    Schema::drop('charters');
  }

}
