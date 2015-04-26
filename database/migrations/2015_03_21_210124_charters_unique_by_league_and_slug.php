<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChartersUniqueByLeagueAndSlug extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('charters', function(Blueprint $table)
    {
      $table->dropUnique('charters_slug_unique');
      $table->unique( array('league_id', 'slug') );
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('charters', function(Blueprint $table)
    {
      $table->dropUnique('charters_league_id_slug_unique');
      $table->unique('slug');
    });
  }

}
