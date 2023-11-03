<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class SuccessEmptyResponse implements Responsable
{
    public function __construct(
        private readonly string $message,
        private readonly int    $status = 200
    )
    {
    }

    public function toResponse($request): Response
    {
        return response([
            'success' => true,
            'message' => $this->message
        ], $this->status);
    }
}
