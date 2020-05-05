<?php
namespace App\Application\Activity\Query;

use App\Domain\Activity\ActivityRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ExposeActivitiesQueryHandler
{
    /** @var ActivityRepositoryInterface */
    private $activityRepository;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(ActivityRepositoryInterface $activityRepository, SerializerInterface $serializer)
    {
        $this->activityRepository = $activityRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(ExposeActivitiesQuery $query)
    {
        $activities = $this->activityRepository->searchAll();

        return $this->serializer->serialize($activities, 'json');
    }
}
