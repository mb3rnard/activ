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

final class DeleteRecordedActivityCommandHandler
{
    /** @var ActivityRecordedRepositoryInterface */
    private $activityRecordedRepository;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        ActivityRecordedRepositoryInterface $activityRecordedRepository,
        ValidatorInterface $validator
    ) {
        $this->activityRecordedRepository = $activityRecordedRepository;
        $this->validator = $validator;
    }

    public function __invoke(DeleteRecordedActivityCommand $command): void
    {
        // Check activity exists + check date is valid

        $activityRecorded = $this->activityRecordedRepository->searchByActivityAndDate($command->getActivityId(),
            \DateTime::createFromFormat('!d-m-Y', $command->getDate()));

        $this->activityRecordedRepository->remove($activityRecorded);
    }
}
