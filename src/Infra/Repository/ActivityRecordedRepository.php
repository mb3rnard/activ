<?php

namespace App\Infra\Repository;

use App\Domain\Activity\ActivityDate;
use App\Domain\Activity\ActivityRecorded;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class ActivityRecordedRepository extends ServiceEntityRepository implements ActivityRecordedRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityRecorded::class);
    }

    public function search(int $id): ?ActivityRecorded
    {
        return $this->find($id);
    }

    public function searchForPeriod(ActivityDate $startDate, ActivityDate $endDate): array
    {
        $queryBuilder = $this->createQueryBuilder('activity_recorded');

        $queryBuilder
            ->where('activity_recorded.completedAt.date >= :startDate')
            ->andWhere('activity_recorded.completedAt.date <= :endDate')
            ->setParameter('startDate', $startDate->getDate())
            ->setParameter('endDate', $endDate->getDate())
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function searchByActivityAndDate(string $activityId, \DateTime $date): ?ActivityRecorded
    {
        $queryBuilder = $this->createQueryBuilder('activity_recorded');

        $queryBuilder
            ->where('activity_recorded.activity = :activityId')
            ->andWhere('activity_recorded.completedAt.date = :date')
            ->setParameter('activityId', $activityId)
            ->setParameter('date', $date)
        ;

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function save(ActivityRecorded $activityRecorded): void
    {
        $this->_em->persist($activityRecorded);
        $this->_em->flush($activityRecorded);
    }

    public function remove(ActivityRecorded $activityRecorded): void
    {
        $this->_em->remove($activityRecorded);
        $this->_em->flush();
    }
}
