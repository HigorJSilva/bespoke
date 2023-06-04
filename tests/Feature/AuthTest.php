<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function test_register(): void
    {
        $response = $this->post(
            '/api/auth/register',
            array_merge($this->getUserData(), ['password_confirmation' => 'password'])
        );

        $response->assertStatus(200);
    }

    public function test_login(): void
    {
        User::create($this->getUserData());
        $response = $this->post('/api/auth/login', $this->getLoginData());

        $response->assertStatus(200);
    }

    public function test_logout(): void
    {
        User::create($this->getUserData());
        $getTokenResponse = $this->post('/api/auth/login', $this->getLoginData());

        $token = $getTokenResponse->json()['token'];

        $response = $this->get('/api/auth/logout', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(204);
    }

    public function test_prevent_register_invalid_data(): void
    {
        $response = $this->json(
            'post',
            '/api/auth/register',
            []
        );

        $response->assertStatus(422);

        $response->assertJson([
            "message" => "The name field is required. (and 3 more errors)",
            "errors" => [
                "name" => [
                    "The name field is required."
                ],
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
                "password_confirmation" => [
                    "The password confirmation field is required."
                ]
            ]
        ]);
    }

    public function test_prevent_login_wrong_credentials(): void
    {
        $loginData = $this->getLoginData();
        $loginData['email'] = 'wrong@Email.com';

        $response = $this->json(
            'post',
            '/api/auth/login',
            $loginData
        );

        $response->assertStatus(422);

        $response->assertJson([
            "message" => "Wrong credentials",
            "errors" => [
                "email" => [
                    "Wrong credentials"
                ]
            ]
        ]);
    }

    public function test_prevent_logout_unauthenticated(): void
    {
        $response = $this->json('get','/api/auth/logout');

        $response->assertStatus(401);
    }

    private function getUserData()
    {
        return [
            'name' => 'bespoke testing',
            'email' => 'bespokeTest@mail.com',
            'password' => 'password'
        ];
    }

    private function getLoginData()
    {
        return [
            'email' => 'bespokeTest@mail.com',
            'password' => 'password',
        ];
    }
}
