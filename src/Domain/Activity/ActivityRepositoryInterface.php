<?php

namespace App\Domain\Activity;

use App\Domain\Shared\EntityId;

interface ActivityRepositoryInterface
{
    public function search(EntityId $id): ?Activity;

    public function searchAll(): array;

    public function save(Activity $activity): void;
}
