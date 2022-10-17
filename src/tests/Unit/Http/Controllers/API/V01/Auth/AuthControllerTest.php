<?php

namespace Tests\Unit\Http\Controllers\API\V01\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_Register_should_be_validated()
    {

        $response = $this->postJson('api/v1/auth/register');

        $response->assertStatus(422);


    }


    public function test_new_user_can_register()
    {


        $response = $this->postJson('api/v1/auth/register', [
            'name' => 'erfan',
            'email' => 'erfanansari@yahoo.com',
            'password' => '123456',
        ]);

        $response->assertStatus(201);


    }

    public function test_login_user_should_be_validated()
    {

        $response = $this->postJson('api/v1/auth/login');

        $response->assertStatus(422);

    }

    public function test_new_user_can_login_with_true_credential()
    {
        $user = Factory::factoryForModel(User::class)->create();

        $response = $this->postJson('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_logout()
    {
        $user = Factory::factoryForModel(User::class)->create();

        $response = $this->actingAs($user)->postJson('api/v1/auth/logout');

        $response->assertStatus(200);

    }


}
