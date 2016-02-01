<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegalNameToSkater extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('skaters', function(Blueprint $table)
    {
      $table->string('legal_name');
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
      $table->dropColumn('legal_name');
    });
  }
}
