<?php

use Billing\Infrastructure\DI\Container;

$definitions = [
    \Billing\Domain\Repository\MerchantRepositoryInterface::class => function (\Psr\Container\ContainerInterface $container) {
        return new \Billing\Infrastructure\Repository\MerchantJsonRepository(
            dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'merchants.json',
            $container->get(\Billing\Infrastructure\Hydrator\MerchantHydrator::class)
        );
    },

    \Billing\Domain\Repository\CustomerRepositoryInterface::class => function (\Psr\Container\ContainerInterface $container) {
        return new \Billing\Infrastructure\Repository\Doctrine\DoctrineCustomerRepository(
            $container->get(\Doctrine\Common\Persistence\ObjectManager::class)
        );
    },

    \Doctrine\Common\Persistence\ObjectManager::class => function (Container $container) {
        $configuration = new Doctrine\ORM\Configuration();
        $configuration->setMetadataDriverImpl(new Doctrine\ORM\Mapping\Driver\XmlDriver(dirname(__DIR__) . '/mapping'));
        $configuration->setProxyDir(sys_get_temp_dir());
        $configuration->setProxyNamespace('ProxyExample');
        $configuration->setAutoGenerateProxyClasses(Doctrine\ORM\Proxy\ProxyFactory::AUTOGENERATE_ALWAYS);

        \Doctrine\DBAL\Types\Type::addType('uuid', Ramsey\Uuid\Doctrine\UuidType::class);
        \Doctrine\DBAL\Types\Type::addType('phoneNumber', \Billing\Infrastructure\Doctrine\Type\PhoneNumberType::class);

        return Doctrine\ORM\EntityManager::create(
            [
                'driverClass' => Doctrine\DBAL\Driver\PDOSqlite\Driver::class,
                'path'        => dirname(__DIR__) . '/data/db.sqlite',
            ],
            $configuration
        );
    },

];

return new Container($definitions);
