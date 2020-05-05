<?php

namespace App\Application\Activity\Command;

use Ramsey\Uuid\Uuid;
use App\Domain\Shared\EntityId;
use App\Domain\Activity\Activity;
use App\Domain\Activity\ActivityRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateActivityCommandHandler
{
    /** @var ActivityRepositoryInterface */
    private $activityRepository;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ActivityRepositoryInterface $activityRepository, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->activityRepository = $activityRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function __invoke(CreateActivityCommand $command): void
    {
        $activity = new Activity(EntityId::fromUuid(Uuid::uuid4()), $command->getName());
        $errors = $this->validator->validate($activity);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
    
            throw new InvalidArgumentException($errorsString);
        }

        $this->activityRepository->save($activity);
    }
}
