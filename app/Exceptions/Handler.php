<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });


        $this->renderable(function(Throwable $e) {
            $status_code = 500;

            if ($e instanceof HttpExceptionInterface) {
                $status_code = $e->getStatusCode();
            }

            return response()->json(['error' => $e->getMessage()], $status_code)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
            
        });

    }
}
