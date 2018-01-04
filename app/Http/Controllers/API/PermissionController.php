<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\IndexPermission;
use App\Http\Requests\StorePermission;
use App\Http\Requests\ShowPermission;
use Illuminate\Support\Facades\Auth;
use Validator;

class PermissionController extends Controller
{
    public function index(IndexPermission $request)
    {
        return new PermissionCollection(Permission::all());
    }

    public function store(StorePermission $request)
    {
        $permission = Permission::create($request->all());
        return $permission;
    }

    public function show(ShowPermission $request, $id)
    {
        return Permission::find($id);
    }
}