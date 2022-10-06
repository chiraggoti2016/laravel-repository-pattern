<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e, $request) {
            
        // });
    }


	public function render($request, Throwable  $exception)
	{

        if ($request->is('api/*')) {

        
            if($request->expectsJson()){
                if($exception instanceof ValidationException){
                    $transformed = [];
    
                    foreach ($exception->errors() as $field => $message) {
                        $transformed[$field] = $message[0];
                    }
                    return response()->json([
                        'errors' => $transformed,
                        'message' => 'The given data was invalid.',
                    ], 422);
                }
    
                if($exception instanceof MethodNotAllowedHttpException || $exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException){
                    return response()->json([
                        'errors' => new \StdClass(),
                        'message' => $exception->getMessage() ?? 'URl/Method/Model Not Found.',
                    ], $exception->getStatusCode() ?? 422);
                }
                
                return response()->json([
                    'message' => $exception->getMessage(),
                ], $exception->getStatusCode());
            }
    
        }

		return parent::render($request, $exception);
	}
}
