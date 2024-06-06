<?php

namespace App\traits;

trait apiResponse
{
    protected function successResponse($data = [] , $message = null, $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => true
        ], $code);
    }

    protected function errorResponse($errors = [], $code = 404)
    {
        if(is_string($errors))
        {
            return response()->json([
                'message' => $errors,
                'status' => false
            ], $code);
        }
        return response()->json([
            'message' => $errors,
            
        ]);
    }

    protected function notAuthorized($message)
    {
        return $this->errorResponse([
            'message' => $message,
            'status' => 401,
            'source' => '',
        ]);
    }
}

