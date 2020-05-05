<?php

namespace App\Infra\Action\Activity;

use App\Infra\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Activity\Query\ExposeActivitiesQuery;

/**
 * @Route("/activities", name="expose_activities")
 */
final class ExposeActivities
{
    /** @var QueryBusInterface */
    private $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request): Response
    {
        $query = new ExposeActivitiesQuery();
        $activities = $this->queryBus->handleQuery($query);

        return new JsonResponse(json_decode($activities));
    }
}
