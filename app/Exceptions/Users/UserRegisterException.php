<?php 

namespace App\Exceptions\Users;

use Exception;
use Illuminate\Http\Response;

class UserRegisterException extends Exception
{
    public function render()
    {
        return response()->json([
            'errors' => [
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                'type'    => 'User register',
                'message' => 'There is an issue registering the user.'
            ] 
        ]);
    }
}