<?php

namespace App\Application\Activity\Command;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;
use App\Domain\Shared\EntityId;
use App\Domain\Activity\ActivityDate;
use App\Domain\Activity\ActivityRecorded;
use App\Domain\Activity\ActivityRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RecordActivityCommandHandler
{
    /** @var ActivityRepositoryInterface */
    private $activityRepository;

    /** @var ActivityRecordedRepositoryInterface */
    private $activityRecordedRepository;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityRecordedRepositoryInterface $activityRecordedRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->activityRepository = $activityRepository;
        $this->activityRecordedRepository = $activityRecordedRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function __invoke(RecordActivityCommand $command): void
    {
        $activity = $this->activityRepository->search(EntityId::fromUuid(Uuid::fromString($command->getActivityId())));

        // Check activity exists + check date is valid

        $activityRecorded = new ActivityRecorded($activity, ActivityDate::fromString($command->getDate()));
        $errors = $this->validator->validate($activity);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
    
            throw new InvalidArgumentException($errorsString);
        }

        $this->activityRecordedRepository->save($activityRecorded);
    }
}
