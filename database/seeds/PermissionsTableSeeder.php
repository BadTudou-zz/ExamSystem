<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPermission = new Permission();
        $createPermission->name         = 'permission-store';
        $createPermission->display_name = 'Create Permission'; // optional
        $createPermission->description  = 'create new permission'; // optional
        $createPermission->save();

        $showPermission = new Permission();
        $showPermission->name         = 'permission-show';
        $showPermission->display_name = 'Show Permission'; // optional
        $showPermission->description  = 'show a permission'; // optional
        $showPermission->save();

        $indexPermission = new Permission();
        $indexPermission->name         = 'permission-index';
        $indexPermission->display_name = 'Show All Permissions'; // optional
        $indexPermission->description  = 'show all permissions'; // optional
        $indexPermission->save();

        $createRole = new Permission();
        $createRole->name         = 'role-store';
        $createRole->display_name = 'Create Role'; // optional
        $createRole->description  = 'create new role'; // optional
        $createRole->save();

        $showRole = new Permission();
        $showRole->name         = 'role-show';
        $showRole->display_name = 'Show Role'; // optional
        $showRole->description  = 'show a role'; // optional
        $showRole->save();

        $indexRole = new Permission();
        $indexRole->name         = 'role-index';
        $indexRole->display_name = 'Show All Roles'; // optional
        $indexRole->description  = 'show all roles'; // optional
        $indexRole->save();
    }
}
