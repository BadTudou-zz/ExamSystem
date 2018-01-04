<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Http\Resources\RoleCollection;
use App\Http\Requests\IndexRole;
use App\Http\Requests\StoreRole;
use App\Http\Requests\ShowRole;
use Illuminate\Support\Facades\Auth;
use Validator;

class RoleController extends Controller
{
    public function index(IndexRole $request)
    {
        return new RoleCollection(Role::all());

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
}