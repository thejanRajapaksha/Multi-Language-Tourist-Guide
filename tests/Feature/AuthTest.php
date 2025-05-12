<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_tourist_user_can_register_and_login_successfully()
    {
        $this->withoutMiddleware(); // Skip CSRF for testing

        // Register a tourist user
        $registerResponse = $this->post('/register', [
            'name' => 'Tourist User',
            'email' => 'tourist@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'user_type' => '1',
            'passport_number' => 'N1234567',
            'nationality' => 'Sri Lankan',
            'income_method' => '1',
            'income_amount' => 5000,
            'currency_used' => 'USD',
            'planned_length_of_stay' => 10,
        ]);

        $registerResponse->assertStatus(302); // Redirect expected
        $this->assertDatabaseHas('users', [
            'email' => 'tourist@example.com',
            'user_type' => 1,
        ]);

        // Login the user
        $loginResponse = $this->post('/login', [
            'email' => 'tourist@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_business_user_can_register_and_login_successfully()
    {
        $this->withoutMiddleware(); // Skip CSRF for testing

        // Register a business user
        $registerResponse = $this->post('/register', [
            'name' => 'Business User',
            'email' => 'business@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'user_type' => 2,
            'business_type' => '1',
            'business_location' => 'Colombo',
            'tax_identification_number' => 'TIN789456',
        ]);

        $registerResponse->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'business@example.com',
            'user_type' => 2,
        ]);

        // Login the user
        $loginResponse = $this->post('/login', [
            'email' => 'business@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(302);
        $this->assertAuthenticated();
    }
}
