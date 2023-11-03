<?php

namespace App\Exceptions;

use App\Http\Responses\ErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if ($response->status() === 404) {
            return new ErrorResponse($e->getMessage(), 404);
        }

        if ($response->status() >= 500 && !app()->isLocal()) {
            Log::error("ERROR", [
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);

            return new ErrorResponse($e->getMessage(), 400);
        }

        return $response;
    }
}
