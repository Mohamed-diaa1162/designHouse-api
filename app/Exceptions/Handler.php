<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function render($request, Throwable $e)
    // {
    //     if ($e instanceof ModelNotFoundException && $request->expectsJson()) {
    //         return response()->json([
    //             'errors' => [
    //                 'message' => 'This Image dosen\'t exsits'
    //             ]
    //         ], 404);
    //     }

    //     if ($e instanceof AuthorizationException && $request->expectsJson()) {
    //         return response()->json(['errors' => [
    //             'Massage' => 'You not have access to do this resource'
    //         ]], 403);
    //     }
    // }
}