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
        $userAdmin = User::where('name', 'admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->perms()->sync(Permission::all());
        $userAdmin->attachRole($adminRole);

        $allCourse  = Permission::where('name', 'course-index')->first();
        $allLecture = Permission::where('name', 'lecture-index')->first();
        $userRole = Role::where('name', 'user')->first();
        $userRole->attachPermissions(array($allCourse, $allLecture));
    }
}
