<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostsTest extends TestCase
{
    public function test_create_post(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        
        $response = $this->postJson('/api/posts', [
            "title" => "Test",
            "body"  => "test body"
        ]);
        
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'body',
                'author_id',
                'updated_at',
                'created_at',
            ]
        ]);
        
        $this->assertDatabaseHas('posts', [
            "title" => "Test",
            "body"  => "test body"
        ]);
    }
    
    public function test_create_post_validation(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        
        $response = $this->postJson('/api/posts', [
            "body"  => "test body"
        ]);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
        
        $this->assertDatabaseMissing('posts', [
            "body"  => "test body"
        ]);
    }
}
