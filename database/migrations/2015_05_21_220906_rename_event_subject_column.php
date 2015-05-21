<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEventSubjectColumn extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('events', function(Blueprint $table)
    {
      $table->renameColumn('subject', 'subject_type');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('events', function(Blueprint $table)
    {
      $table->renameColumn('subject_type', 'subject');
    });
  }

}
