<?php

use Illuminate\Database\Seeder;

class PermissionsRolesTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('permission_role')->delete();

    $permissions = [
      // root user
      ['role_id' => 1, 'permission_id' => 1 ],  // home
      ['role_id' => 1, 'permission_id' => 2 ],  // user-show
      ['role_id' => 1, 'permission_id' => 3 ],  // user-create
      ['role_id' => 1, 'permission_id' => 4 ],  // user-edit
      ['role_id' => 1, 'permission_id' => 5 ],  // user-delete
      ['role_id' => 1, 'permission_id' => 6 ],  // league-show
      ['role_id' => 1, 'permission_id' => 7 ],  // league-create
      ['role_id' => 1, 'permission_id' => 8 ],  // league-edit
      ['role_id' => 1, 'permission_id' => 9 ],  // league-delete
      ['role_id' => 1, 'permission_id' => 10 ], // charter-show
      ['role_id' => 1, 'permission_id' => 11 ], // charter-create
      ['role_id' => 1, 'permission_id' => 12 ], // charter-edit
      ['role_id' => 1, 'permission_id' => 13 ], // charter-delete
      ['role_id' => 1, 'permission_id' => 14 ], // charter-request_approval
      ['role_id' => 1, 'permission_id' => 15 ], // charter-approve
      ['role_id' => 1, 'permission_id' => 16 ], // charter-reject
      ['role_id' => 1, 'permission_id' => 17 ], // event-show
      ['role_id' => 1, 'permission_id' => 18 ], // user-archived
      ['role_id' => 1, 'permission_id' => 19 ], // league-archived
      ['role_id' => 1, 'permission_id' => 20 ], // charter-archived

      // staff
      ['role_id' => 2, 'permission_id' => 1 ],  // home
      ['role_id' => 2, 'permission_id' => 2 ],  // user-show
      ['role_id' => 2, 'permission_id' => 3 ],  // user-create
      ['role_id' => 2, 'permission_id' => 4 ],  // user-edit
      ['role_id' => 2, 'permission_id' => 6 ],  // league-show
      ['role_id' => 2, 'permission_id' => 7 ],  // league-create
      ['role_id' => 2, 'permission_id' => 8 ],  // league-edit
      ['role_id' => 2, 'permission_id' => 10 ], // charter-show
      ['role_id' => 2, 'permission_id' => 15 ], // charter-approve
      ['role_id' => 2, 'permission_id' => 16 ], // charter-reject
      ['role_id' => 2, 'permission_id' => 17 ], // event-show
      ['role_id' => 2, 'permission_id' => 18 ], // user-archived
      ['role_id' => 2, 'permission_id' => 19 ], // league-archived
      ['role_id' => 2, 'permission_id' => 20 ], // charter-archived

      // league
      ['role_id' => 3, 'permission_id' => 1 ],  // home
      ['role_id' => 3, 'permission_id' => 2 ],  // user-show
      ['role_id' => 3, 'permission_id' => 4 ],  // user-edit
      ['role_id' => 3, 'permission_id' => 6 ],  // league-show
      ['role_id' => 3, 'permission_id' => 8 ],  // league-edit
      ['role_id' => 3, 'permission_id' => 10 ], // charter-show
      ['role_id' => 3, 'permission_id' => 11 ], // charter-create
      ['role_id' => 3, 'permission_id' => 12 ], // charter-edit
      ['role_id' => 3, 'permission_id' => 14 ], // charter-request_approval
    ];

    // Uncomment the below to run the seeder
    DB::table('permission_role')->insert( $permissions );
  }

}
