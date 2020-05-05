<?php

use App\Infra\Bus\CommandBusInterface;
use App\Infra\Bus\QueryBusInterface;
use App\Infra\Bus\MessengerCommandBus;
use App\Infra\Bus\MessengerQueryBus;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $sc) {
    // Defaults
    $services = $sc->services()->defaults()->private()->autoconfigure()->autowire();
    $services
        ->alias(CommandBusInterface::class, MessengerCommandBus::class)
        ->alias(QueryBusInterface::class, MessengerQueryBus::class)
    ;
};
