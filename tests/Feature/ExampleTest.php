<?php

namespace Tests\Feature;

use App\User;
use App\Admin;
use Tests\TestCase;
use App\Organization;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testUser()
    // {
    //     $user = factory(User::class)->create();
    //     $this->actingAs($user);
    //     $response = $this->getJson(route('user.index'));
    //     $response->assertStatus(200);
    // }


    // public function testAdmin()
    // {
    //     $admin = factory(Admin::class)->create();
    //     $this->actingAs($admin, 'admin');

    //     $user = factory(User::class)->create();
    //     $organization = $user->organization;
    //     $response = $this->getJson(route('admin.organization-show', ['organization_id' => $organization->id]));
    //     dd($response->json());
    //     $response->assertStatus(200);
    // }


    /**
     * @group tttt
     */
    public function test_create_user_success()
    {
        $admin = factory(Admin::class)->create(['role_id' => Admin::MASTER]);
        $this->actingAs($admin, 'admin');
        $organization = factory(Organization::class)->create();
        $params = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'hogehoge12'
        ];

        $response = $this->postJson(route('admin.user-store', ['organization_id' => $organization->id]), $params);
        $response->assertStatus(201);

        $data = $response->json();
        $this->assertEquals($params['name'], $data['name']);
        $this->assertEquals($params['email'], $data['email']);
        $this->assertEquals($organization->id, $data['organization_id']);
    }

    /**
     * @group tttt
     */
    public function test_create_user_fail_403()
    {
        $admin = factory(Admin::class)->create(['role_id' => Admin::READONLY]);
        $this->actingAs($admin, 'admin');
        $organization = factory(Organization::class)->create();
        $params = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'hogehoge12'
        ];

        $response = $this->postJson(route('admin.user-store', ['organization_id' => $organization->id]), $params);
        $response->assertStatus(403);
    }

    /**
     * @group tttt
     */
    public function test_create_user_fail_duplicate_email()
    {
        $admin = factory(Admin::class)->create(['role_id' => Admin::MASTER]);
        $this->actingAs($admin, 'admin');
        $organization = factory(Organization::class)->create();
        $params = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'hogehoge12'
        ];

        // 事前に作成
        factory(User::class)->create([
            'organization_id' => $organization->id,
            'email' => $params['email'],
        ]);
        $response = $this->postJson(route('admin.user-store', ['organization_id' => $organization->id]), $params);
        $response->assertStatus(422);
        $message = $response->json()['errors']['email'][0];
        $this->assertEquals(
            'すでに登録されているアドレスになります。',
            $message
        );
    }

    /**
     * @group tttt
     */
    public function test_create_user_fail_model_not_found_organization()
    {
        $admin = factory(Admin::class)->create(['role_id' => Admin::MASTER]);
        $this->actingAs($admin, 'admin');
        $organization = factory(Organization::class)->create();
        $params = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'hogehoge12'
        ];
        $response = $this->postJson(route('admin.user-store', ['organization_id' => $organization->id + 1]), $params);
        $response->assertStatus(404);
    }
}
