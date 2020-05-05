<?php

namespace App\Domain\Activity;

interface ActivityRecordedRepositoryInterface
{
    public function search(int $id): ?ActivityRecorded;

    public function searchForPeriod(ActivityDate $startDate, ActivityDate $endDate): array;

    public function searchByActivityAndDate(string $activityId, \DateTime $date): ?ActivityRecorded;

    public function save(ActivityRecorded $activityRecorded): void;
}
