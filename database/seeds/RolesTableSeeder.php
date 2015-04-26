<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('roles')->delete();

    $roles = array(
      ['id' => 1, 'name' => 'root',   'display_name' => 'Root',        'Description' => 'Developers',           'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 2, 'name' => 'staff',  'display_name' => 'UKRDA Staff', 'Description' => 'Organisational staff', 'created_at' => new DateTime, 'updated_at' => new DateTime],
      ['id' => 3, 'name' => 'league', 'display_name' => 'League',      'Description' => 'Member leagues',       'created_at' => new DateTime, 'updated_at' => new DateTime],
    );

    // Uncomment the below to run the seeder
    DB::table('roles')->insert( $roles );
  }

}
