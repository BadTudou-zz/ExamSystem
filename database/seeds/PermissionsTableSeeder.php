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
        $createPermission->display_name = 'Create Permission';
        $createPermission->description  = 'create new permission';
        $createPermission->save();

        $showPermission = new Permission();
        $showPermission->name         = 'permission-show';
        $showPermission->display_name = 'Show Permission';
        $showPermission->description  = 'show a permission';
        $showPermission->save();

        $indexPermission = new Permission();
        $indexPermission->name         = 'permission-index';
        $indexPermission->display_name = 'Show All Permissions';
        $indexPermission->description  = 'show all permissions';
        $indexPermission->save();

        $createRole = new Permission();
        $createRole->name         = 'role-store';
        $createRole->display_name = 'Create Role';
        $createRole->description  = 'create new role';
        $createRole->save();

        $showRole = new Permission();
        $showRole->name         = 'role-show';
        $showRole->display_name = 'Show Role';
        $showRole->description  = 'show a role';
        $showRole->save();

        $indexRole = new Permission();
        $indexRole->name         = 'role-index';
        $indexRole->display_name = 'Show All Roles';
        $indexRole->description  = 'show all roles';
        $indexRole->save();

        $updateRole = new Permission();
        $updateRole->name         = 'role-update';
        $updateRole->display_name = 'Update A Role';
        $updateRole->description  = 'update a role';
        $updateRole->save();

        $showUser = new Permission();
        $showUser->name         = 'user-index';
        $showUser->display_name = 'Show All Users';
        $showUser->description  = 'Show All Users';
        $showUser->save();

        $updateUser = new Permission();
        $updateUser->name         = 'user-update';
        $updateUser->display_name = 'Update A User';
        $updateUser->description  = 'Update A User';
        $updateUser->save();
    }
}
