<?php

namespace Tests\Feature;

use App\User;
use App\Admin;
use Tests\TestCase;
use App\Organization;

class ExampleTest extends TestCase
{
    private Organization $organization;
    protected function setUp(): void
    {
        parent::setUp();

        $admin = factory(Admin::class)->create(['role_id' => Admin::MASTER]);
        $this->actingAs($admin, 'admin');
        $this->organization = factory(Organization::class)->create();
    }

    /**
     * @group tttt
     */
    public function test_create_user_success()
    {
        $params = $this->params();

        $response = $this->postJson(route('admin.user-store', ['organization_id' => $this->organization->id]), $params);
        $response->assertStatus(201);

        $data = $response->json();
        $this->assertEquals($params['name'], $data['name']);
        $this->assertEquals($params['email'], $data['email']);
        $this->assertEquals($this->organization->id, $data['organization_id']);
    }

    /**
     * @group tttt
     */
    public function test_create_user_fail_403()
    {
        $admin = factory(Admin::class)->create(['role_id' => Admin::READONLY]);
        $this->actingAs($admin, 'admin');

        $response = $this->postJson(route('admin.user-store', ['organization_id' => $this->organization->id]), $this->params());
        $response->assertStatus(403);
    }

    /**
     * @group tttt
     */
    public function test_create_user_fail_duplicate_email()
    {
        // 事前に作成
        factory(User::class)->create([
            'organization_id' => $this->organization->id,
            'email' => $this->params()['email'],
        ]);
        $response = $this->postJson(route('admin.user-store', ['organization_id' => $this->organization->id]), $this->params());
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
        $response = $this->postJson(route('admin.user-store', ['organization_id' => $this->organization->id + 1]), $this->params());
        $response->assertStatus(404);
    }

    private function params(): array
    {
        return [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'hogehoge12'
        ];
    }
}
