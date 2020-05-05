<?php

use App\Domain\Activity\Activity;
use App\Domain\Shared\EntityId;
use Ramsey\Uuid\Uuid;

return [
    Activity::class => [
        'activity-1' => [
            '__construct' => [
                'id' => EntityId::fromUuid(Uuid::uuid4()),
                'name' => 'Basketball'
            ]
        ]
    ]
];
