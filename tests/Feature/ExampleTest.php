<?php

namespace Tests\Feature;

use App\Admin;
use App\User;
use Tests\TestCase;
use App\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->getJson(route('user.index'));
        $response->assertStatus(200);
    }


    public function testAdmin()
    {
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin, 'admin');
        $organization = factory(Organization::class)->create();
        $response = $this->getJson(route('admin.organization-show', ['organization_id' => $organization->id]));
        $response->assertStatus(200);
    }
}
