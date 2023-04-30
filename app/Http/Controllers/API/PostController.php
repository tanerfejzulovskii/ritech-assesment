<?php
   
namespace App\Http\Controllers\API;

use App\Exceptions\Posts\PostException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostService $service)
    {}
    
    /**
     * Create new post
     *
     * @param  App\Http\Requests\PostCreateRequest
     * @return App\Http\Resources\PostResource
     */
    public function store(PostCreateRequest $request): PostResource
    {
        $data = $request->validated();
        
        try {
            $post = $this->service->store($data);
        } catch (Exception $exception) {
            throw new PostException($exception->getMessage());
        }

        return new PostResource($post);
    }
    
    /**
     * Update post
     *
     * @param  App\Http\Requests\PostUpdateRequest
     * @param  App\Models\Post
     * @return App\Http\Resources\PostResource
     */
    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $data = $request->validated();
        
        try {
            $post = $this->service->update($data, $post);
        } catch (Exception $exception) {
            throw new PostException($exception->getMessage());
        }

        return new PostResource($post);
    }
}