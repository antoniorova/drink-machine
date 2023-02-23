<?php

declare(strict_types=1);

use DrinkMachine\Application\Handler\DrinkMakerHandler;
use DrinkMachine\Infrastructure\Ui\Console\DrinkMachineCommand;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->load('DrinkMachine\\Infrastructure\\', '../src/Infrastructure')
        ->autoconfigure(true)
        ->autowire(true)
    ;

    $services->set(DrinkMakerHandler::class, DrinkMakerHandler::class);
    $services->set(DrinkMachineCommand::class, DrinkMachineCommand::class)
        ->tag('console.command');
};
