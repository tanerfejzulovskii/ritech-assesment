<?php 

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function store(array $data): Post
    {
        $post = auth()->user()->posts()->create([
            'title' => $data['title'],
            'body'  => $data['body']
        ]);
        
        return $post;
    }
}