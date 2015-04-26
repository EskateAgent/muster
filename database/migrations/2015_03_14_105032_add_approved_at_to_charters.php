<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedAtToCharters extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('charters', function(Blueprint $table)
    {
      $table->timestamp('approved_at')->nullable();
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
      $table->dropColumn('approved_at');
    });
  }

}
