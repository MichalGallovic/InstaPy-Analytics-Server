<?php

namespace App\Exceptions;

use App\Profile;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ApiValidationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 401);
        }

        if ($exception instanceof ModelNotFoundException) {
            $models = [
                Profile::class => "profile"
            ];
            $exceptionFromModel = $exception->getModel();

            if (isset($models[$exceptionFromModel])) {
                return response()->json([
                    'error' => sprintf("Resource '%s' not found", $models[$exceptionFromModel])
                ], 404);
            }
        }

        return parent::render($request, $exception);
    }
}
