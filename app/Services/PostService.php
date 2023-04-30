<?php 

namespace App\Services;

use App\Models\Post;

class PostService
{
    /**
     * Store record
     *
     * @param  array $data
     * @return App\Models\Post
     */
    public function store(array $data): Post
    {
        return auth()->user()->posts()->create([
            'title' => $data['title'],
            'body'  => $data['body']
        ]);        
    }
    
    /**
     * Update record
     *
     * @param  array $data
     * @param  App\Models\Post $post
     * @return App\Models\Post
     */
    public function update(array $data, Post $post): Post
    {
        $insertData = [];

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $insertData[$key] = $value;
            }
        }

        return tap($post)->update($insertData); 
    }
    
    public function delete(Post $post)
    {
        return $post->delete();
    }
}