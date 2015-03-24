<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToLeague extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('leagues', function(Blueprint $table)
    {
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('leagues', function(Blueprint $table)
    {
      $table->dropColumn('user_id');
    });
  }

}
