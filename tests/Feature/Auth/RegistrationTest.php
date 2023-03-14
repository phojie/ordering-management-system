<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'firstName' => 'Test',
            'middleName' => 'User',
            'imageUrl' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
            'lastName' => 'Test',

            'password' => 'password',
            'passwordConfirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
