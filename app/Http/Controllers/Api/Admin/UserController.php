<?php

namespace App\Http\Controllers\Api\Admin;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    private $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest  $request
     * @param int $organizationId
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request, int $organizationId)
    {
        $validated = $request->validated();
        $organization = $this->organization->findOrFail($organizationId);

        $user = $organization->users()->create($validated);

        return $user;
    }
}
