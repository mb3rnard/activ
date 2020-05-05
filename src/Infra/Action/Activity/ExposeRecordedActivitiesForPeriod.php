<?php

namespace App\Infra\Action\Activity;

use App\Application\Activity\Query\ExposeRecordedActivitiesForPeriodQuery;
use App\Infra\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/recorded-activities/{startDate}/{endDate}", name="expose_recorded_activities_for_period")
 */
final class ExposeRecordedActivitiesForPeriod
{
    /** @var QueryBusInterface */
    private $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request, string $startDate, string $endDate): Response
    {
        $query = new ExposeRecordedActivitiesForPeriodQuery($startDate, $endDate);
        $recordedActivities = $this->queryBus->handleQuery($query);

        return new JsonResponse(json_decode($recordedActivities));
    }
}
