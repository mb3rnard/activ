<?php

namespace App\Infra\Bus;

use App\Infra\Bus\QueryBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait { handle as public; }

    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(MessageBusInterface $queryMessageBus)
    {
        $this->messageBus = $queryMessageBus;
    }

    public function handleQuery($query)
    {
        return $this->handle($query);
    }
}
