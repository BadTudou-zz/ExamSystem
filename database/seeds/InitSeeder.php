<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = User::find(1);
        $adminRole = Role::find(1);
        $adminRole->perms()->sync(Permission::all());
        $userAdmin->attachRole($adminRole);
    }
}
