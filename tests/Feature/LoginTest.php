<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     */

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('email', 'test@test.com')->first();
        if($user){
            $user->delete();
        }
        UserFactory::new()->create([
            'email' => 'test@test.com',
            'password' => 'password',
        ]);
    }

    public function test_successfull_login(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    public function test_unsuccessfull_login(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/login', [
            'email' => 'test@test.com',
            'password' => 'passwordd',
        ]);

        $this->assertGuest();
    }



}
