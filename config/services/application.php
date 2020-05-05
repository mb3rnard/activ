<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $sc) {
    // Defaults
    $services = $sc->services()->defaults()->private()->autoconfigure()->autowire();
};
