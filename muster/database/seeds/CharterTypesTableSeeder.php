<?php

use Illuminate\Database\Seeder;

class CharterTypesTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('charter_types')->delete();

    $charter_types = array(
      ['id' => 1, 'name' => 'Female', 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 2, 'name' => 'Male',   'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 3, 'name' => 'Co-ed',  'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 4, 'name' => 'Junior', 'created_at' => new DateTime, 'updated_at' => new DateTime],
    );

    // Uncomment the below to run the seeder
    DB::table('charter_types')->insert( $charter_types );
  }

}
