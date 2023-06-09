<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    /**
     * List records
     *
     * @return \Illuminate\\Pagination\\LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return auth()->user()
                     ->posts()
                     ->paginate(10);
    }
    
    /**
     * Read record
     *
     * @param  Post $post
     * @return App\Models\Post
     */
    public function read(Post $post): Post
    {
        return $post;
    }
    
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
    
    /**
     * Delete record
     *
     * @param Post $post
     * @return void
     */
    public function delete(Post $post)
    {
        return $post->delete();
    }
}