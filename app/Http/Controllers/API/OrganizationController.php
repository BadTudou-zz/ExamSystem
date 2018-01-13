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
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Organization;



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

}