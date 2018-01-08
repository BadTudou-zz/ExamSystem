<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理员
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description  = 'User is allowed to manage and edit other users';
        $admin->save();

        // 教师
        $teacher = new Role();
        $teacher->name         = 'teacher';
        $teacher->display_name = '教师';
        $teacher->description  = '教师';
        $teacher->save();

        // 学生
        $student = new Role();
        $student->name         = 'student';
        $student->display_name = '学生';
        $student->description  = '学生';
        $student->save();

    }
}
