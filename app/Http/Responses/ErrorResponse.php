<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ErrorResponse implements Responsable
{
    public function __construct(
        private readonly string $message,
        private readonly int    $status
    )
    {
    }

    public function toResponse($request)
    {
        return response([
            'success' => false,
            'message' => $this->message
        ], $this->status);
    }
}
