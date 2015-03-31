<?php

use Illuminate\Database\Seeder;

class PermissionsRolesTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('permission_role')->delete();

    $permissions = array(
      // root user
      ['role_id' => 1, 'permission_id' => 1 ],  // user-show
      ['role_id' => 1, 'permission_id' => 2 ],  // user-create
      ['role_id' => 1, 'permission_id' => 3 ],  // user-edit
      ['role_id' => 1, 'permission_id' => 4 ],  // user-destroy
      ['role_id' => 1, 'permission_id' => 5 ],  // league-show
      ['role_id' => 1, 'permission_id' => 6 ],  // league-create
      ['role_id' => 1, 'permission_id' => 7 ],  // league-edit
      ['role_id' => 1, 'permission_id' => 8 ],  // league-destroy
      ['role_id' => 1, 'permission_id' => 9 ],  // charter-show
      ['role_id' => 1, 'permission_id' => 10 ], // charter-create
      ['role_id' => 1, 'permission_id' => 11 ], // charter-edit
      ['role_id' => 1, 'permission_id' => 12 ], // charter-destroy
      ['role_id' => 1, 'permission_id' => 13 ], // charter-request_approval
      ['role_id' => 1, 'permission_id' => 14 ], // charter-approve
      ['role_id' => 1, 'permission_id' => 15 ], // charter-reject

      // staff
      ['role_id' => 2, 'permission_id' => 1 ],  // user-show
      ['role_id' => 2, 'permission_id' => 3 ],  // user-edit
      ['role_id' => 2, 'permission_id' => 5 ],  // league-show
      ['role_id' => 2, 'permission_id' => 6 ],  // league-create
      ['role_id' => 2, 'permission_id' => 7 ],  // league-edit
      ['role_id' => 2, 'permission_id' => 9 ],  // charter-show
      ['role_id' => 2, 'permission_id' => 14 ], // charter-approve
      ['role_id' => 2, 'permission_id' => 15 ], // charter-reject

      // league
      ['role_id' => 3, 'permission_id' => 1 ],  // user-show
      ['role_id' => 3, 'permission_id' => 3 ],  // user-edit
      ['role_id' => 3, 'permission_id' => 5 ],  // league-show
      ['role_id' => 3, 'permission_id' => 7 ],  // league-edit
      ['role_id' => 3, 'permission_id' => 9 ],  // charter-show
      ['role_id' => 3, 'permission_id' => 10 ], // charter-create
      ['role_id' => 3, 'permission_id' => 11 ], // charter-edit
      ['role_id' => 3, 'permission_id' => 13 ], // charter-request_approval
    );

    // Uncomment the below to run the seeder
    DB::table('permission_role')->insert( $permissions );
  }

}
