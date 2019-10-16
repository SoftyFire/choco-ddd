<?php
declare(strict_types=1);

namespace Billing\Tests\Integration\Repository;

use Billing\Domain\Aggregate\Customer;
use Billing\Domain\Aggregate\Merchant;
use Billing\Domain\DTO\Customer\CustomerRegistrationDto;
use Billing\Domain\DTO\Merchant\MerchantRegistrationDto;
use Billing\Domain\Repository\CustomerRepositoryInterface;
use Billing\Domain\Repository\MerchantRepositoryInterface;
use Billing\Tests\Integration\TestCase;
use Ramsey\Uuid\Uuid;

class CustomerRepositoryTest extends TestCase
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->container->get(CustomerRepositoryInterface::class);
    }

    public function testMerchantCanBeSaved(): void
    {
        $dto = CustomerRegistrationDto::fromArray([
            'id' => Uuid::uuid4(),
            'phone' => '+7123456789'
        ]);
        $customer = Customer::register($dto);
        $this->repo->save($customer);

        $dbCustomer = $this->repo->getById(Uuid::fromString($dto->id));
        $this->assertSame($customer->id()->toString(), $dbCustomer->id()->toString());
        $this->assertSame($customer->phone(), $dbCustomer->phone());
    }
}
