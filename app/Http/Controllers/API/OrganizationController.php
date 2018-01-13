<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\IndexOrganization;
use App\Http\Requests\ShowOrganization;
use App\Http\Requests\StoreOrganization;
use App\Http\Requests\UpdateOrganization;
use App\Http\Requests\DestroyOrganization;
use App\Http\Requests\AddUsersToOrganization;
use App\Http\Requests\DeleteUsersFromOrganization;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Organization;
use App\User;

class OrganizationController extends Controller
{
    public function index(IndexOrganization $request)
    {
        return new OrganizationCollection(Organization::paginate());
    }

    public function show(ShowOrganization $request, $id)
    {
        return new OrganizationResource(Organization::findOrFail($id));
    }

    public function update(UpdateOrganization $request, $id)
    {
        $organization = Organization::find($id);
        $organization->update($request->all());
        return new OrganizationResource($organization);
    }

    public function store(StoreOrganization $request)
    {   
        $request->request->add(
            [
                'creator_id' => Auth::user()->id,
                'max' => $request->get('max', '0'),
                'current' => 1
            ]
        );
        $organization = Organization::create($request->all());
        return $organization;
    }

    public function destroy(DestroyOrganization $request, $id)
    {
        Organization::find($id)->delete();
    }

    public function users($id)
    {
        return new UserCollection(Organization::find($id)->users()->paginate());
    }

    public function AddUsers(AddUsersToOrganization $request, $id)
    {
        $organization = Organization::find($id);
        $users = User::find($request->users);
        $organization->users()->syncWithoutDetaching($users);
    }

    public function DeleteUsers(DeleteUsersFromOrganization $request, $id)
    {
        $organization = Organization::find($id);
        $users = User::find($request->users);
        $organization->users()->detach($users);
    }

    public function SyncUsers(UpdateOrganization $request, $id)
    {
        $organization = Organization::find($id);
        $users = User::find($request->users);
        $organization->users()->sync($users);
    }

}