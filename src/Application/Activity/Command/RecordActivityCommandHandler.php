<?php

namespace App\Application\Activity\Command;

use App\Application\ErrorHandling\ApiError;
use App\Application\ErrorHandling\ApiErrorException;
use Ramsey\Uuid\Uuid;
use InvalidArgumentException;
use App\Domain\Shared\EntityId;
use App\Domain\Activity\ActivityDate;
use App\Domain\Activity\ActivityRecorded;
use App\Domain\Activity\ActivityRepositoryInterface;
use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RecordActivityCommandHandler
{
    /** @var ActivityRepositoryInterface */
    private $activityRepository;

    /** @var ActivityRecordedRepositoryInterface */
    private $activityRecordedRepository;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityRecordedRepositoryInterface $activityRecordedRepository,
        ValidatorInterface $validator
    ) {
        $this->activityRepository = $activityRepository;
        $this->activityRecordedRepository = $activityRecordedRepository;
        $this->validator = $validator;
    }

    public function __invoke(RecordActivityCommand $command): void
    {
        $activity = $this->activityRepository->search(EntityId::fromUuid(Uuid::fromString($command->getActivityId())));

        // Check activity exists + check date is valid

        $activityRecorded = new ActivityRecorded($activity, ActivityDate::fromString($command->getDate()));
        $errors = $this->validator->validate($activityRecorded);

        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $error) {
                $violations[str_replace(['[', ']'], ['', ''], $error->getPropertyPath())] = $error->getMessage();
            }

            $apiError = new ApiError(400, ApiError::TYPE_VALIDATION_ERROR);
            $apiError->set('errors', $errors);

            throw new ApiErrorException($apiError);
        }

        $this->activityRecordedRepository->save($activityRecorded);
    }
}
