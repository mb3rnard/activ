<?php

namespace App\Infra\Bus;

interface CommandBusInterface
{
    public function handleCommand($command);
}
