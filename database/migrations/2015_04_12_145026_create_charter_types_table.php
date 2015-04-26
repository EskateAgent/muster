<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharterTypesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('charter_types', function(Blueprint $table)
    {
      $table->increments('id');
      $table->text('name');
      $table->timestamps();
    });

    Schema::table('charters', function(Blueprint $table)
    {
      $table->integer('charter_type_id')->unsigned();
      $table->foreign('charter_type_id')->references('id')->on('charter_types')->onDelete('restrict');
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
      $table->dropForeign('charters_charter_type_id_foreign');
      $table->dropColumn('charter_type_id');
    });

    Schema::drop('charter_types');
  }

}
