<?php

namespace App\Infra\Repository;

use App\Domain\Activity\Activity;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Activity\ActivityRepositoryInterface;
use App\Domain\Shared\EntityId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class ActivityRepository extends ServiceEntityRepository implements ActivityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function search(EntityId $id): ?Activity
    {
        return $this->find($id);
    }

    /** @return Activity[] */
    public function searchAll(): array
    {
        return $this->findAll();
    }

    public function save(Activity $activity): void
    {
        $this->_em->persist($activity);
        $this->_em->flush($activity);
    }
}
