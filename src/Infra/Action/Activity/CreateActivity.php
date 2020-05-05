<?php

namespace App\Infra\Action\Activity;

use App\Infra\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Activity\Command\CreateActivityCommand;

/**
 * @Route("/activities/new", name="create_activity")
 */
final class CreateActivity
{
    /** @var CommandBusInterface */
    private $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $command = new CreateActivityCommand($request->request->get('name'));
        $this->commandBus->handleCommand($command);

        return new JsonResponse('success');
    }
}
