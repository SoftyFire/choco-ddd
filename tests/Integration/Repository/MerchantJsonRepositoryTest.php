<?php
declare(strict_types=1);

namespace Billing\Tests\Integration\Repository;

use Billing\Domain\Aggregate\Merchant;
use Billing\Domain\DTO\Merchant\MerchantRegistrationDto;
use Billing\Domain\Repository\MerchantRepositoryInterface;
use Billing\Tests\Integration\TestCase;
use Ramsey\Uuid\Uuid;

class MerchantJsonRepositoryTest extends TestCase
{
    /**
     * @var MerchantRepositoryInterface
     */
    protected $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->container->get(MerchantRepositoryInterface::class);
    }

    public function testMerchantCanBeSaved(): void
    {
        $dto = MerchantRegistrationDto::fromArray([
            'id' => Uuid::uuid4(),
            'name' => 'Foo Bar'
        ]);
        $merchant = Merchant::register($dto);
        $this->repo->save($merchant);

        $dbMerchant = $this->repo->getById(Uuid::fromString($dto->id));
        $this->assertSame($merchant->id()->toString(), $dbMerchant->id()->toString());
        $this->assertSame($merchant->name(), $dbMerchant->name());
    }
}
