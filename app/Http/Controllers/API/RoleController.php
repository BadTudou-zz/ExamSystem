<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\User;
use App\Http\Resources\RoleCollection;
use App\Http\Requests\IndexRole;
use App\Http\Requests\StoreRole;
use App\Http\Requests\ShowRole;
use App\Http\Requests\DestroyRole;
use App\Http\Requests\SyncPermissionsToRole;
use  App\Http\Requests\SyncUsersToRole;
use App\Http\Requests\AttachPermissionsFromRole;
use App\Http\Requests\DetachPermissionsFromRole;
use App\Http\Requests\AttachUsersToRole;
use App\Http\Requests\DetachUsersToRole;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\RoleResource;

use Illuminate\Support\Facades\Auth;
use Validator;

class RoleController extends Controller
{
    public function index(IndexRole $request)
    {
        return new RoleCollection(Role::paginate());

    }

    public function store(StoreRole $request)
    {
        $role = Role::create($request->all());
        return $role;
    }

    public function show(ShowRole $request, $id)
    {
        return new RoleResource(Role::find($id));
    }

    public function destroy(DestroyRole $request, $id)
    {
        Role::find($id)->delete();
    }

    // 同步角色权限
    public function syncPermissions(SyncPermissionsToRole $request, $id)
    {
        Role::find($id)->perms()->sync($request->permissions);
    }

    // 给角色添加权限
    public function attachPermissions(AttachPermissionsToRole $request, $id)
    {
        $role = Role::find($id);
        $permissions = array_column($role->perms->all(), 'id');
        $role->perms()->sync(array_merge($permissions,$request->permissions));
    }

    // 从角色删除权限
    public function detachPermissions(DetachPermissionsFromRole $request, $id)
    {
        $role = Role::find($id);
        $permissions = array_column($role->perms->all(), 'id');
        $role->perms()->sync(array_diff($permissions,$request->permissions));
    }

    // 给角色同步用户
    public function syncUsers(SyncUsersToRole $request, $id)
    {
        Role::find($id)->users()->sync($request->users);
    }

    // 给角色添加用户
    public function attachUsers(AttachUsersToRole $request, $id)
    {
        $role = Role::find($id);
        $users = array_column($role->users->all(), 'id');
        $role->users()->sync(array_merge($users,$request->users));
    }

    // 从角色删除用户
    public function detachUsers(DetacUsersFromRole $request, $id)
    {
        $role = Role::find($id);
        $users = array_column($role->users->all(), 'id');
        $role->users()->sync(array_diff($users, $request->users));
    }

    // 获取角色的权限
    public function permissions(IndexRole $request, $id)
    {
        return new PermissionCollection(Role::find($id)->perms()->paginate());
    }

    // 获取角色的用户
    public function users(IndexRole $request, $id)
    {
        return new UserCollection(Role::find($id)->users()->paginate());
    }

}