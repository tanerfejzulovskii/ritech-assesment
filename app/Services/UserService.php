<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class UserService
{
    public function register(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'password' => bcrypt($data['password']),
            'email'    => $data['email']
        ]);
        
        $user['token'] =  $user->createToken('MyApp')->plainTextToken;
        
        return $user;
    }
    
    public function login(array $data): User
    {
        if (!User::canLogin($data)) {
            throw new UnauthorizedException();
        }
        
        $user = Auth::user(); 
        
        $user['token'] = $user->createToken('MyApp')->plainTextToken;
        
        return $user;
    }
}