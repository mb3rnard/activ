<?php

namespace App\Application\ErrorHandling;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class ApiErrorException extends HttpException
{
    private ApiError $apiError;

    public function __construct(
        ApiError $apiError,
        \Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        $this->apiError = $apiError;

        parent::__construct($apiError->getStatusCode(), $apiError->getTitle(), $previous, $headers, $code);
    }

    public function getApiError(): ApiError
    {
        return $this->apiError;
    }
}
