<?php

namespace App\Infra\Action;

use App\Application\ErrorHandling\ApiError;
use App\Application\ErrorHandling\ApiErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class ErrorHandlingApiAction
{
    protected function handleErrors(ConstraintViolationListInterface $validationErrors): JsonResponse
    {
        $errors = [];
        foreach ($validationErrors as $violation) {
            $errors[str_replace(['[', ']'], ['', ''], $violation->getPropertyPath())] = $violation->getMessage();
        }

        $apiError = new ApiError(400, ApiError::TYPE_VALIDATION_ERROR);
        $apiError->set('errors', $errors);

        throw new ApiErrorException($apiError);
    }
}
