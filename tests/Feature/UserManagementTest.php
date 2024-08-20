<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;

class UserManagementTest extends TestCase
{
    /**
     * A basic test example.
     */

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('email', 'test@testadmin.com')->first();
        if($user){
            $user->delete();
        }

        UserFactory::new()->create([
            'email' => 'test@testadmin.com',
            'password' => 'password',
            'role' => 'admin',
        ]);


        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/login', [
            'email' => 'test@testadmin.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    protected function tearDown(): void
    {
        $user = User::where('email', 'test@testadmin.com')->first();
        if($user){
            $user->delete();
        }
        $user = User::where('email', 'test@testnew.com')->first();
        if($user){
            $user->delete();
        }
        parent::tearDown();
    }

    public function test_user_list(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/users');

        $response->assertStatus(200);
    }

    public function test_create_user(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/users', [
            'name' => 'Test User',
            'email' => 'test@testnew.com',
            'password' => 'password',
            'role' => 'user',
            'confirm_password' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertNotNull($user);
    }

    public function test_show_user(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/users', [
            'name' => 'Test User',
            'email' => 'test@testnew.com',
            'password' => 'password',
            'role' => 'user',
            'confirm_password' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertNotNull($user);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/users/' . $user->id);

        $response->assertStatus(200);
    }


    public function test_update_user(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/users', [
            'name' => 'Test User',
            'email' => 'test@testnew.com',
            'password' => 'password',
            'role' => 'user',
            'confirm_password' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertNotNull($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/users/' . $user->id, [
            'name' => 'Test User Updated',
            'email' => 'test@testnew.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $response->assertStatus(200);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertEquals('Test User Updated', $user->name);
    }

    public function test_delete_user(): void{
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/users', [
            'name' => 'Test User',
            'email' => 'test@testnew.com',
            'password' => 'password',
            'role' => 'user',
            'confirm_password' => 'password',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertNotNull($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete('/api/users/' . $user->id);

        $response->assertStatus(200);

        $user = User::where('email', 'test@testnew.com')->first();
        $this->assertNull($user);

    }

}
