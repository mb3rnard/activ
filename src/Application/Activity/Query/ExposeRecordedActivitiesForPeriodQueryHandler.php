<?php
namespace App\Application\Activity\Query;

use App\Domain\Activity\ActivityDate;
use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use App\Domain\Activity\ActivityRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ExposeRecordedActivitiesForPeriodQueryHandler
{
    /** @var ActivityRepositoryInterface */
    private $activityRepository;

    /** @var ActivityRecordedRepositoryInterface */
    private $activityRecordedRepository;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityRecordedRepositoryInterface $activityRecordedRepository,
        SerializerInterface $serializer
    ) {
        $this->activityRepository = $activityRepository;
        $this->activityRecordedRepository = $activityRecordedRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(ExposeRecordedActivitiesForPeriodQuery $query): string
    {
        $startDate = ActivityDate::fromString($query->getStartDate());
        $endDate = ActivityDate::fromString($query->getEndDate());

        $activities = $this->activityRepository->searchAll();
        $activitiesRecorded = $this->activityRecordedRepository->searchForPeriod($startDate, $endDate);
        $data = [];

        $period = new \DatePeriod($startDate->getDate(), new \DateInterval('P1D'), $endDate->getDate());

        // init view array
        foreach ($period as $date) {
            foreach ($activities as $activity) {
                $data[$date->format(ActivityDate::CLEAN_FORMAT)][$activity->getName()] = false;
            }
        }

        // fill array
        foreach ($activitiesRecorded as $activityRecorded) {
            $data[$activityRecorded->getCompletedAt()->getDate()->format(ActivityDate::CLEAN_FORMAT)][$activityRecorded->getActivity()->getName()] = true;
        }

        return $this->serializer->serialize($data, 'json');
    }
}
