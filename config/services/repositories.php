<?php

use App\Infra\Repository\ActivityRepository;
use App\Domain\Activity\ActivityRepositoryInterface;
use App\Infra\Repository\ActivityRecordedRepository;
use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $sc) {
    // Defaults
    $services = $sc->services()->defaults()->private()->autoconfigure()->autowire();
    $services
        // Define implementations to use for each repository interface
        ->alias(ActivityRepositoryInterface::class, ActivityRepository::class)
        ->alias(ActivityRecordedRepositoryInterface::class, ActivityRecordedRepository::class)
    ;
};
