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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct(protected PostService $service)
    {}
    
    /**
     * List all posts
     *
     * @param  Request $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        try {
            $posts = $this->service->list();
        } catch (Exception $exception) {
            throw new PostException($exception->getMessage());
        }

        return PostResource::collection($posts);
    }
    
    /**
     * Show post
     *
     * @param  Request $request
     * @param  Post $post
     * @return App\Http\Resources\PostResource
     */
    public function show(Request $request, Post $post): PostResource
    {
        try {
            $post = $this->service->read($post);
        } catch (Exception $exception) {
            throw new PostException($exception->getMessage());
        }

        return new PostResource($post);
    }
    
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
    
    /**
     * Delete post
     *
     * @param  \Illuminate\Http\Request
     * @param  App\Models\Post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Post $post): JsonResponse
    {
        try {
            $post = $this->service->delete($post);
        } catch (Exception $exception) {
            throw new PostException($exception->getMessage());
        }

        return response()->json([
            'status'  => Response::HTTP_OK,
            'message' => 'Post removed successfully'
        ]);
    }
}