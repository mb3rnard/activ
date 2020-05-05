<?php

namespace App\Application\Activity\Command;

final class DeleteRecordedActivityCommand
{
    private string $activityId;

    private string $date;

    public function __construct(string $activityId, string $date)
    {
        $this->activityId = $activityId;
        $this->date = $date;
    }

    public function getActivityId():string
    {
        return $this->activityId;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
