<?php

namespace App\Http\Controllers\Api\Admin;

use App\Admin;
use App\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Auth\Access\AuthorizationException;

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
        $admin = Auth::user();
        if ($admin->role_id !== Admin::MASTER) {
            throw new AuthorizationException('権限がありません');
        }
        $validated = $request->validated();
        $organization = $this->organization->findOrFail($organizationId);

        $user = $organization->users()->create($validated);

        return $user;
    }
}
