<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e, $request) {
            dd('e');
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 404);
            }
        });
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
                        'message' => 'URl/Method/Model Not Found.',
                    ], 404);
                }
                
                return response()->json([
                    'message' => $exception->getMessage(),
                ], $exception->getStatusCode());
            }
    
        }

		return parent::render($request, $exception);
	}
}
