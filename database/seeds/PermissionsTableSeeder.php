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
        // 创建权限
        $createPermission = new Permission();
        $createPermission->name         = 'permission-store';
        $createPermission->display_name = 'Create Permission';
        $createPermission->description  = 'create new permission';
        $createPermission->save();

        // 查看权限详情
        $showPermission = new Permission();
        $showPermission->name         = 'permission-show';
        $showPermission->display_name = 'Show Permission';
        $showPermission->description  = 'show a permission';
        $showPermission->save();

        // 删除权限
        $destroyPermission = new Permission();
        $destroyPermission->name         = 'permission-destroy';
        $destroyPermission->display_name = 'Destroy A Permission';
        $destroyPermission->description  = 'Destroy a permission';
        $destroyPermission->save();

        // 查看权限列表
        $indexPermission = new Permission();
        $indexPermission->name         = 'permission-index';
        $indexPermission->display_name = 'Show All Permissions';
        $indexPermission->description  = 'show all permissions';
        $indexPermission->save();

        // 创建角色
        $createRole = new Permission();
        $createRole->name         = 'role-store';
        $createRole->display_name = 'Create Role';
        $createRole->description  = 'create new role';
        $createRole->save();

        // 查看角色详情
        $showRole = new Permission();
        $showRole->name         = 'role-show';
        $showRole->display_name = 'Show Role';
        $showRole->description  = 'show a role';
        $showRole->save();

        // 查看角色列表
        $indexRole = new Permission();
        $indexRole->name         = 'role-index';
        $indexRole->display_name = 'Show All Roles';
        $indexRole->description  = 'show all roles';
        $indexRole->save();

        // 修改角色详情
        $updateRole = new Permission();
        $updateRole->name         = 'role-update';
        $updateRole->display_name = 'Update A Role';
        $updateRole->description  = 'update a role';
        $updateRole->save();

        // 删除角色
        $destroyRole = new Permission();
        $destroyRole->name         = 'role-destroy';
        $destroyRole->display_name = 'Destroy A Role';
        $destroyRole->description  = 'Destroy a role';
        $destroyRole->save();

        // 查看用户列表
        $showUser = new Permission();
        $showUser->name         = 'user-index';
        $showUser->display_name = 'Show All Users';
        $showUser->description  = 'Show All Users';
        $showUser->save();

        // 修改用户详情
        $updateUser = new Permission();
        $updateUser->name         = 'user-update';
        $updateUser->display_name = 'Update A User';
        $updateUser->description  = 'Update A User';
        $updateUser->save();

        // 删除用户
        $destroyUser = new Permission();
        $destroyUser->name         = 'user-destroy';
        $destroyUser->display_name = 'Destroy A User';
        $destroyUser->description  = 'Destroy A User';
        $destroyUser->save();

        // 查看消息列表
        $indexMessage = new Permission();
        $indexMessage->name         = 'message-index';
        $indexMessage->display_name = 'Show All Message';
        $indexMessage->description  = 'Show All Message';
        $indexMessage->save();

        // 创建消息
        $storeMessage = new Permission();
        $storeMessage->name         = 'message-store';
        $storeMessage->display_name = 'Create Message';
        $storeMessage->description  = 'Create Message';
        $storeMessage->save();

        // 查看消息详情
        $showMessage = new Permission();
        $showMessage->name         = 'message-show';
        $showMessage->display_name = 'Show A Message';
        $showMessage->description  = 'Show A Message';
        $showMessage->save();

        // 删除消息
        $destroyMessage = new Permission();
        $destroyMessage->name         = 'message-destroy';
        $destroyMessage->display_name = 'Destroy A Message';
        $destroyMessage->description  = 'Destroy A Message';
        $destroyMessage->save();

         // 查看通知列表
        $indexNotification = new Permission();
        $indexNotification->name         = 'notification-index';
        $indexNotification->display_name = 'Show All Notification';
        $indexNotification->description  = 'Show All Notification';
        $indexNotification->save();

        // 创建通知
        $storeNotification = new Permission();
        $storeNotification->name         = 'notification-store';
        $storeNotification->display_name = 'Create Notification';
        $storeNotification->description  = 'Create Notification';
        $storeNotification->save();

        // 查看通知详情
        $showNotification = new Permission();
        $showNotification->name         = 'notification-show';
        $showNotification->display_name = 'Show A Notification';
        $showNotification->description  = 'Show A Notification';
        $showNotification->save();

        // 删除通知
        $destroyNotification = new Permission();
        $destroyNotification->name         = 'notification-destroy';
        $destroyNotification->display_name = 'Destroy A Notification';
        $destroyNotification->description  = 'Destroy A Notification';
        $destroyNotification->save();

    }
}
