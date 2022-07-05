<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    private $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function show(int $organizationId)
    {
        $organization = $this->organization->with('users')->findOrFail($organizationId);

        return $organization;
    }
}
