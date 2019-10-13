<?php

use Billing\Infrastructure\DI\Container;

$definitions = [
    \Billing\Domain\Repository\MerchantRepositoryInterface::class => function (\Psr\Container\ContainerInterface $container) {
        return new \Billing\Infrastructure\Repository\MerchantJsonRepository(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'merchants.json',
            $container->get(\Billing\Infrastructure\Hydrator\MerchantHydrator::class)
        );
    }
];

return new Container($definitions);
