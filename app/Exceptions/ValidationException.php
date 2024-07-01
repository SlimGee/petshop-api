<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException as DefaultValidationException;

class ValidationException extends DefaultValidationException
{
    public function render($request): JsonResponse
    {
        return new JsonResponse([
            'error' => $this->getMessage(),
            'success' => false,
            'data' => [],
            'errors' => $this->validator->errors()->getMessages(),
            'trace' => [],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
