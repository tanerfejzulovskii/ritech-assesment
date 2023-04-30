<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UsersTest extends TestCase
{
    public function test_register_user(): void
    {
        $response = $this->postJson('/api/register', [
            "name"     => "Test",
            "email"    => "test@test.com",
            "password" => "12345"
        ]);
        
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id',
                'token'
            ]
        ]);
        
        $this->assertDatabaseHas('users', [
            "name"     => "Test",
            "email"    => "test@test.com"
        ]);
    }
    
    public function test_register_user_validation(): void
    {
        $response = $this->postJson('/api/register', [
            "email"    => "test@test.com",
            "password" => "12345"
        ]);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
        
        $this->assertDatabaseMissing('users', [
            "email"    => "test@test.com"
        ]);
    }
    
    public function test_login_user(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345')
        ]);
        
        $response = $this->postJson('/api/login', [
            "email"    => $user['email'],
            "password" => "12345"
        ]);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id',
                'token'
            ]
        ]);
    }
    
    public function test_login_user_validation(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345')
        ]);
        
        $response = $this->postJson('/api/login', [
            "email"    => "test@test.com"
        ]);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
}
