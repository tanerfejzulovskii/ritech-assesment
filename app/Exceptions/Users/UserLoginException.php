<?php 

namespace App\Exceptions\Users;

use Exception;
use Illuminate\Http\Response;

class UserLoginException extends Exception
{
    public function render()
    {
        return response()->json([
            'errors' => [
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                'type'    => 'User login',
                'message' => 'There is an issue logging the user.'
            ] 
        ]);
    }
}