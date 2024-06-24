<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    // protected $handlers = [
    //     ValidationException::class => 'handleValidationException',
    //     ModelNotFoundException::class => 'handleModelNotFoundException',
    //     AuthenticationException::class => 'unauthenticatedException',
    //     QueryException::class => 'handleQueryException',
    // ];

    // private function handleValidationException(ValidationException $exception)
    // {
    //     $errors = [];
    //     foreach($exception->errors() as $key => $value)
    //     {
    //         foreach($value as $message)
    //         {
    //             $errors[] = [
    //                 'type' => 'ValidationException',
    //                 'status' => 422,
    //                 'message' => $message,
    //                 'source' => $key,
    //             ];
    //         }
    //     }

    //     return $errors;
    // }

    // private function handleModelNotFoundException(ModelNotFoundException $exception)
    // {
    //     return [
    //         'type' => 'ModelNotFoundException',
    //         'status' => 404,
    //         'message' => 'The requested resource was not found',
    //         'source' => $exception->getModel(),
    //     ];
    // }

    // private function unauthenticatedException(AuthenticationException $exception)
    // {
    //     return [
    //         'type' => 'AuthenticationException', // 'type' => 'AuthenticationException
    //         'status' => 401,
    //         'message' => $exception->getMessage(),
    //         'source' => '',
    //     ];
    // }

    // private function handleQueryException(QueryException $exception)
    // {
    //     return [
    //         'type' => 'QueryException',
    //         'status' => 500,
    //         'message' => $exception->getMessage(),
    //         'source' => 'Line: '.$exception->getLine().':'.$exception->getFile(),
    //     ];
    // }

    // public function register(): void
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    // public function render($request, Throwable $exception)
    // {
    //     $className = get_class($exception);

    //     if(array_key_exists($className, $this->handlers))
    //     {
    //         $method = $this->handlers[$className];
    //         return $this->errorResponse($this->$method($exception), $this->$method($exception)['status']);
    //     }

    //     $index = strrpos($className, '\\');

    //     return $this->errorResponse([
    //         'type' => substr($className, $index + 1),
    //         'status' => 500,
    //         'message' => $exception->getMessage(),
    //         'source' => 'Line: '.$exception->getLine().':'.$exception->getFile(),
    //     ], 500);
    // }
}
