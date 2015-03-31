<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

  public function run()
  {
    // Uncomment the below to wipe the table clean before populating
    DB::table('permissions')->delete();

    $permissions = array(
      ['id' => 1,  'name' => 'user-show',                'display_name' => 'Show User',        'Description' => 'view users',                    'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 2,  'name' => 'user-create',              'display_name' => 'Create User',      'Description' => 'create new users',              'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 3,  'name' => 'user-edit',                'display_name' => 'Edit User',        'Description' => 'edit existing users',           'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 4,  'name' => 'user-destroy',             'display_name' => 'Destroy User',     'Description' => 'destroy users',                 'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 5,  'name' => 'league-show',              'display_name' => 'Show League',      'Description' => 'view leagues',                  'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 6,  'name' => 'league-create',            'display_name' => 'Create League',    'Description' => 'create new leagues',            'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 7,  'name' => 'league-edit',              'display_name' => 'Edit League',      'Description' => 'edit existing leagues',         'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 8,  'name' => 'league-destroy',           'display_name' => 'Destroy League',   'Description' => 'destroy leagues',               'created_at' => new DateTime, 'updated_at' => new DateTime ],

      ['id' => 9,  'name' => 'charter-show',             'display_name' => 'Show Charter',     'Description' => 'view charters',                 'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 10, 'name' => 'charter-create',           'display_name' => 'Create Charter',   'Description' => 'create new charters',           'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 11, 'name' => 'charter-edit',             'display_name' => 'Edit Charter',     'Description' => 'edit existing charters',        'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 12, 'name' => 'charter-destroy',          'display_name' => 'Destroy Charter',  'Description' => 'destroy charters',              'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 13, 'name' => 'charter-request_approval', 'display_name' => 'Request Approval', 'Description' => 'request approval for charters', 'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 14, 'name' => 'charter-approve',          'display_name' => 'Approve Charter',  'Description' => 'approve charters',              'created_at' => new DateTime, 'updated_at' => new DateTime ],
      ['id' => 15, 'name' => 'charter-reject',           'display_name' => 'Reject Charter',   'Description' => 'reject charters',               'created_at' => new DateTime, 'updated_at' => new DateTime ],
    );

    // Uncomment the below to run the seeder
    DB::table('permissions')->insert( $permissions );
  }

}
