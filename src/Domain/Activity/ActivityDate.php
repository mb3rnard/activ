<?php

namespace App\Domain\Activity;

use DateTime;

final class ActivityDate
{
    const FORMAT = '!d-m-Y';
    const CLEAN_FORMAT = 'd-m-Y';

    private DateTime $date;

    private string $day;

    private function __construct()
    {
    }

    public static function fromString(string $date): ActivityDate
    {
        $activityDate = new ActivityDate();

        $activityDate->date = DateTime::createFromFormat(ActivityDate::FORMAT, $date);
        $activityDate->day = $activityDate->date->format('l');

        return $activityDate;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}
