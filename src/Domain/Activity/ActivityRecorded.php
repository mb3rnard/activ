<?php

namespace App\Domain\Activity;

final class ActivityRecorded
{
    private int $id;

    private Activity $activity;

    private ActivityDate $completedAt;

    public function __construct(Activity $activity, ActivityDate $completedAt)
    {
        $this->activity = $activity;
        $this->completedAt = $completedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getActivity(): Activity
    {
        return $this->activity;
    }

    public function getCompletedAt(): ActivityDate
    {
        return $this->completedAt;
    }
}
