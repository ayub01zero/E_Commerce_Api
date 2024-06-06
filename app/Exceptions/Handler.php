<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\traits\apiResponse;
use Illuminate\Validation\ValidationException;




class Handler extends ExceptionHandler
{
    use apiResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $handlers = [
        ValidationException::class => 'handleValidationException',
        ModelNotFoundException::class => 'handleModelNotFoundException',
        AuthenticationException::class => 'unauthenticatedException',
    ];

    private function handleValidationException(ValidationException $exception)
    {
        foreach($exception->errors() as $key => $value)
        {
            foreach($value as $message)
            {
                $errors[] = [
                    'status' => 422,
                    'message' => $message,
                    'source' => $key,
                ];
            }
        }

        return $errors;
    }

    private function handleModelNotFoundException(ModelNotFoundException $exception)
    {
        return [
            'status' => 404,
            'message' => 'The requested resource was not found',
            'source' => $exception->getModel(),
        ];
    }

    private function unauthenticatedException(AuthenticationException $exception)
    {
        return [
            'status' => 401,
            'message' => $exception->getMessage(),
            'source' => '',
        ];
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   public function render($request, Throwable $exception)
    {

        $className = get_class($exception);

        if(array_key_exists($className, $this->handlers))
        {
            $method = $this->handlers[$className];
            return $this->errorResponse($this->$method($exception));
        }

        $index = strrpos($className, '\\');

       return $this->errorResponse([
           'type' => substr($className, $index + 1),
           'status' => 0,
           'message' => $exception->getMessage(),
           'source' =>  'Line: '.$exception->getLine().':'.$exception->getFile(),
       ]);
    }

}
