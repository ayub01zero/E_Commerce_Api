<?php

namespace App\traits;

trait apiResponse
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => true
        ], $code);
    }

    protected function errorResponse($message = null, $code = 404)
    {
        return response()->json([
            'message' => $message,
            'status' => false
        ], $code);
    }
}

