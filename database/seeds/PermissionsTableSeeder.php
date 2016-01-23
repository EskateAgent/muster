<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('permissions')->delete();

    $permissions = array(
      ['id' => 1,  'name' => 'home',                     'display_name' => 'Home',             'Description' => 'view home',                     'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 2,  'name' => 'user-show',                'display_name' => 'Show User',        'Description' => 'view users',                    'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 3,  'name' => 'user-create',              'display_name' => 'Create User',      'Description' => 'create new users',              'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 4,  'name' => 'user-edit',                'display_name' => 'Edit User',        'Description' => 'edit existing users',           'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 5,  'name' => 'user-delete',              'display_name' => 'Delete User',      'Description' => 'delete users',                  'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 6,  'name' => 'league-show',              'display_name' => 'Show League',      'Description' => 'view leagues',                  'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 7,  'name' => 'league-create',            'display_name' => 'Create League',    'Description' => 'create new leagues',            'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 8,  'name' => 'league-edit',              'display_name' => 'Edit League',      'Description' => 'edit existing leagues',         'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 9,  'name' => 'league-delete',            'display_name' => 'Delete League',    'Description' => 'delete leagues',                'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 10, 'name' => 'charter-show',             'display_name' => 'Show Charter',     'Description' => 'view charters',                 'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 11, 'name' => 'charter-create',           'display_name' => 'Create Charter',   'Description' => 'create new charters',           'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 12, 'name' => 'charter-edit',             'display_name' => 'Edit Charter',     'Description' => 'edit existing charters',        'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 13, 'name' => 'charter-delete',           'display_name' => 'Delete Charter',   'Description' => 'delete charters',               'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 14, 'name' => 'charter-request_approval', 'display_name' => 'Request Approval', 'Description' => 'request approval for charters', 'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 15, 'name' => 'charter-approve',          'display_name' => 'Approve Charter',  'Description' => 'approve charters',              'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 16, 'name' => 'charter-reject',           'display_name' => 'Reject Charter',   'Description' => 'reject charters',               'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 17, 'name' => 'event-show',               'display_name' => 'Show Event',       'Description' => 'view audit log events',         'created_at' => new DateTime, 'updated_at' => new DateTime ],
    );

    // Uncomment the below to run the seeder
    DB::table('permissions')->insert( $permissions );
  }

}
