<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCharterUniqueIndex extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('charters', function(Blueprint $table)
    {
      $table->dropForeign('charters_league_id_foreign');
      $table->dropForeign('charters_charter_type_id_foreign');
      $table->dropUnique('charters_league_id_slug_unique');
      $table->foreign('league_id')->references('id')->on('leagues')->onDelete('restrict');
      $table->foreign('charter_type_id')->references('id')->on('charter_types')->onDelete('restrict');
      $table->unique( array('league_id', 'charter_type_id', 'slug') );
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
      $table->dropForeign('charters_league_id_foreign');
      $table->dropForeign('charters_charter_type_id_foreign');
      $table->dropUnique('charters_league_id_charter_type_id_slug_unique');
      $table->foreign('league_id')->references('id')->on('leagues')->onDelete('restrict');
      $table->foreign('charter_type_id')->references('id')->on('charter_types')->onDelete('restrict');
      $table->unique( array('league_id', 'slug') );
    });
  }

}
