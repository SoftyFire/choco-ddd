<?php
declare(strict_types=1);

namespace Billing\Domain\Repository;

use Billing\Domain\Aggregate\Customer;
use Ramsey\Uuid\UuidInterface;

interface CustomerRepositoryInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Customer
     * @throws \OutOfBoundsException when Merchant was not found
     */
    public function getById(UuidInterface $uuid): Customer;

    public function save(Customer $customer): void;
}
