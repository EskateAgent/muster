<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToLeagues extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('leagues', function(Blueprint $table)
    {
      $table->string('slug')->default('')->unique();
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
      $table->dropColumn('slug');
    });
  }

}
