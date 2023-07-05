<?php

namespace App\Exceptions;

use Error;
use ErrorException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Intervention\Image\Exception\NotFoundException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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

        if (env('APP_DEBUG') == false) {
            
            $this->renderable(function (InvalidArgumentException $e, $request) {
                logger($e->getMessage());
                show_500();
            });

            $this->renderable(function (ErrorException $e, $request) {
                logger($e->getMessage());
                show_500();
            });

            $this->renderable(function (Exception $e, $request) {
                logger($e->getMessage());
                if (preg_match("/^5/", $e->getCode())) {
                    show_500();
                }
            });

            $this->renderable(function (Error $e, $request) {
                logger($e->getMessage());
                show_500();
            });
            
        }
        
    }
}
