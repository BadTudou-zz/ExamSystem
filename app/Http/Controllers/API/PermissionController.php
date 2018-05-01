<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\Permission\Index as IndexPermission;
use App\Http\Requests\Permission\Store as StorePermission;
use App\Http\Requests\Permission\Show as ShowPermission;
use App\Http\Requests\Permission\Destroy as DestroyPermission;
use App\Http\Requests\Permission\Update as UpdatePermission;
use App\Http\Resources\PermissionResource;
use Illuminate\Support\Facades\Auth;
use Validator;

class PermissionController extends Controller
{
    public function index(IndexPermission $request)
    {
        return new PermissionCollection(Permission::paginate());
    }

    public function store(StorePermission $request)
    {
        $permission = Permission::create($request->all());
        return new PermissionResource($permission);
    }

    public function update(UpdatePermission $request)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->except(['name']));
        return new PermissionResource($permission);
    }

    public function show(ShowPermission $request, $id)
    {
        return new PermissionResource(Permission::find($id));
    }

    public function destroy(DestroyPermission $request, $id)
    {
        Permission::find($id)->delete();
    }

}