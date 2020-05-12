<?php

namespace App\Infra\Action\Activity;

use App\Application\ErrorHandling\ApiError;
use App\Application\ErrorHandling\ApiErrorException;
use App\Infra\Action\ErrorHandlingApiAction;
use App\Infra\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Activity\Command\RecordActivityCommand;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/activities/record", name="record_activity")
 */
final class RecordActivity extends ErrorHandlingApiAction
{
    /** @var CommandBusInterface */
    private $commandBus;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(CommandBusInterface $commandBus, ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            $apiError = new ApiError(400, APIError::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiErrorException($apiError);
        }

        $validationErrors = $this->validateInput($data);

        return $validationErrors->count()
            ? $this->handleErrors($validationErrors)
            : $this->recordActivity($data);
    }

    private function recordActivity(array $data): JsonResponse
    {
        $command = new RecordActivityCommand($data['activity_id'], $data['date']);
        $this->commandBus->handleCommand($command);

        return new JsonResponse('success');
    }

    private function validateInput(array $input): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'activity_id' => new Assert\Uuid(),
                'date' => [new Assert\NotBlank(), new Assert\DateTime(['format' => 'd-m-Y'])],
            ]
        );

        return $this->validator->validate($input, $constraint);
    }
}
