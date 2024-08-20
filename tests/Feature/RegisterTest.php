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
