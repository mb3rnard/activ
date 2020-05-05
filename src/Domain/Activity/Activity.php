<?php

namespace App\Domain\Activity;

use App\Domain\Shared\EntityId;
use App\Domain\Shared\TimestampableTrait;

class Activity
{
    use TimestampableTrait;

    private EntityId $id;

    private string $name;

    public function __construct(EntityId $id, string $name, \DateTimeInterface $createdAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->initTimestampable($createdAt);
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
