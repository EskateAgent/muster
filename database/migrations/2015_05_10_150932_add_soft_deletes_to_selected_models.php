<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToSelectedModels extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('charters', function(Blueprint $table)
    {
      $table->softDeletes();
    });

    Schema::table('leagues', function(Blueprint $table)
    {
      $table->softDeletes();
    });

    Schema::table('users', function(Blueprint $table)
    {
      $table->softDeletes();
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
      $table->dropColumn('deleted_at');
    });

    Schema::table('leagues', function(Blueprint $table)
    {
      $table->dropColumn('deleted_at');
    });

    Schema::table('users', function(Blueprint $table)
    {
      $table->dropColumn('deleted_at');
    });
  }

}
