<?php
declare(strict_types=1);

namespace Billing\Infrastructure\Repository\Doctrine;

use Billing\Domain\Aggregate\Customer;
use Billing\Domain\Repository\CustomerRepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\UuidInterface;

final class DoctrineCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param UuidInterface $uuid
     * @return Customer
     * @throws \OutOfBoundsException when Merchant was not found
     */
    public function getById(UuidInterface $uuid): Customer
    {
        $res = $this->objectManager->find(Customer::class, $uuid->toString());


        return $res;
    }

    public function save(Customer $customer): void
    {
        $this->objectManager->persist($customer);
        $this->objectManager->flush();
    }
}
