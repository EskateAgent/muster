<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkaterNumberMustBeUniqueByCharter extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('skaters', function(Blueprint $table)
    {
      $table->unique( array('charter_id', 'number') );
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('skaters', function(Blueprint $table)
    {
      $table->dropUnique('skaters_charter_id_number_unique');
    });
  }

}
