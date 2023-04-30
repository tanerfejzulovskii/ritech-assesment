<?php
   
namespace App\Http\Controllers\API;

use App\Exceptions\Users\UserLoginException;
use App\Exceptions\Users\UserRegisterException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {}
    
    /**
     * Register api
     *
     * @param  App\Http\Requests\UserRegisterRequest
     * @return App\Http\Resources\UserResource
     */
    public function register(UserRegisterRequest $request): UserResource
    {
        $data = $request->validated();
        
        try {
            $user = $this->service->register($data);
        } catch (Exception $exception) {
            throw new UserRegisterException();
        }

        return new UserResource($user);
    }
   
    /**
     * Login api
     *
     * @param  App\Http\Requests\UserLoginRequest
     * @return App\Http\Resources\UserResource
     */
    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();
        
        try {
            $user = $this->service->login($data);
        } catch (Exception $exception) {
            throw new UserLoginException();
        }
        
        return new UserResource($user);
    }
}