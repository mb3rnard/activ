<?php

namespace App\Infra\Action\Activity;

use App\Infra\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Activity\Command\RecordActivityCommand;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/activities/record", name="record_activity")
 */
final class RecordActivity
{
    /** @var CommandBusInterface */
    private $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $command = new RecordActivityCommand($data['activity_id'], $data['date']);
        $this->commandBus->handleCommand($command);

        return new JsonResponse('success');
    }
}
