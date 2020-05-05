<?php

namespace App\Infra\Action\Activity;

use App\Application\Activity\Command\DeleteRecordedActivityCommand;
use App\Infra\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/recorded-activities/delete/{activityId}/{date}", name="delete_recorded_activity", methods={"DELETE"})
 */
final class DeleteRecordedActivity
{
    /** @var CommandBusInterface */
    private $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request, string $activityId, string $date): Response
    {
        $command = new DeleteRecordedActivityCommand($activityId, $date);
        $this->commandBus->handleCommand($command);

        return new JsonResponse('success');
    }
}
