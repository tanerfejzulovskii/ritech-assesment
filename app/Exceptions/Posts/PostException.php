<?php 

namespace App\Exceptions\Posts;

use Exception;
use Illuminate\Http\Response;

class PostException extends Exception
{
    public function render()
    {
        return response()->json([
            'errors' => [
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
                'type'    => 'Posts',
                'message' => $this->getMessage()
            ] 
        ]);
    }
}