<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     */


    public function test_successfull_register(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/register', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rodo_accepted' => true,
            'city' => 'City',
            'street' => 'Street',
            'zip_code' => '00-000',
            'phone_number' => '+48123456789',
        ]);

        $response->assertStatus(201);
    }

    public function test_unsuccessfull_register(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/register', [
            'name' => 'Test User',
            'email' => 'asd',
            'password' => 'pa',
            'password_confirmation' => 'passwordss',
        ]);

        $response->assertStatus(422);
    }

}
