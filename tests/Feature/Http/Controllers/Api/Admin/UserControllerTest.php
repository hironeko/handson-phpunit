<?php

namespace Tests\Feature\Http\Controllers\Api\Admin;

use App\Admin;
use App\Organization;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * ユーザーの作成ができる
     */
    public function testCreateUserSuccess()
    {
        $admin = factory(Admin::class)->create([
            'role_id' => Admin::MASTER
        ]);

        $organization = factory(Organization::class)->create();
        $this->actingAs($admin, 'admin');
        $params = [
            'name' => 'test',
            'email' => 'sample@sample.com',
            'password' => '123456test'
        ];
        $response = $this->postJson(
            route(
                'admin.user-store',
                ['organization_id' => $organization->id]
            ),
            $params
        );

        $response->assertStatus(201);
        $data = $response->json();
        $this->assertEquals($params['name'], $data['name']);
        $this->assertEquals($params['email'], $data['email']);
        $this->assertEquals($organization->id, $data['organization_id']);
    }

    /**
     * emailが重複している場合はvalidationエラーになる
     * @group sample
     */
    public function testCreateUserFailDuplicateEmail()
    {
        $admin = factory(Admin::class)->create([
            'role_id' => Admin::MASTER
        ]);

        $organization = factory(Organization::class)->create();
        $this->actingAs($admin, 'admin');
        $params = [
            'name' => 'test',
            'email' => 'sample@sample.com',
            'password' => '123456test'
        ];

        factory(User::class)->create([
            'organization_id' => $organization->id,
            'email' => $params['email']
        ]);

        $response = $this->postJson(
            route(
                'admin.user-store',
                ['organization_id' => $organization->id]
            ),
            $params
        );

        $response->assertStatus(422);
        $data = $response->json();
        $this->assertEquals(
            'すでに登録されているアドレスになります。',
            $data['errors']['email'][0]
        );
    }
}
