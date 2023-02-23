<?php

declare(strict_types=1);

namespace DrinkMachine\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return array<BundleInterface>
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
        ];
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $frameworkConfigLoader = require __DIR__ . '/../../../config/framework.php';
        $frameworkConfigLoader($container->withPath(__DIR__ . '/../../../config/framework.php'));
        $servicesConfigLoader = require __DIR__ . '/../../../config/services.php';
        $servicesConfigLoader($container->withPath(__DIR__ . '/../../../config/services.php'));
    }

    public function getCacheDir(): string
    {
        $env = (string)$this->environment;

        return __DIR__ . '/../../../var/' . $env . '/cache';
    }

    public function getLogDir(): string
    {
        $env = (string)$this->environment;

        return __DIR__ . '/../../../var/' . $env . '/log';
    }
}
