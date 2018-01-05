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
use App\Http\Requests\AttachPermissionsToRole;
use App\Http\Requests\DetachPermissionsToRole;
use App\Http\Requests\AttachUsersToRole;
use App\Http\Requests\DetachUsersToRole;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\UserCollection;
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
        return Role::find($id);
    }

    // 给角色赋予权限
    public function attachPermissions(AttachPermissionsToRole $request, $id)
    {
        Role::find($id)->perms()->sync($request->permissions);
    }

    // 给角色赋予用户
    public function attachUsers(AttachUsersToRole $request, $id)
    {
        Role::find($id)->users()->sync($request->users);
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