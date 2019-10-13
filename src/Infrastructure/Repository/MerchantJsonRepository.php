<?php
declare(strict_types=1);

namespace Billing\Infrastructure\Repository;

use Billing\Domain\Aggregate\Merchant;
use Billing\Domain\Repository\MerchantRepositoryInterface;
use Billing\Infrastructure\Hydrator\MerchantHydrator;
use Ramsey\Uuid\UuidInterface;

/**
 * Class MerchantJsonRepository
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class MerchantJsonRepository implements MerchantRepositoryInterface
{
    /**
     * @var string
     */
    private $jsonFileLocation;

    /**
     * @var MerchantHydrator
     */
    private $hydrator;

    public function __construct(string $jsonFileLocation, MerchantHydrator $hydrator)
    {
        $this->jsonFileLocation = $jsonFileLocation;
        $this->hydrator = $hydrator;

        $this->initializeDb();
    }

    private function readJson(): array
    {
        return json_decode(file_get_contents($this->jsonFileLocation), true);
    }

    private function initializeDb()
    {
        if (!file_exists($this->jsonFileLocation)) {
            file_put_contents($this->jsonFileLocation, '{}');
        }
    }

    /**
     * @param UuidInterface $uuid
     * @return Merchant
     * @throws \OutOfBoundsException when Merchant was not found
     */
    public function getById(UuidInterface $uuid): Merchant
    {
        $uuidString = $uuid->toString();
        $db = $this->readJson();

        if (!isset($db[$uuidString])) {
            throw new \OutOfRangeException(sprintf('%s not found', $uuidString));
        }

        return $this->hydrator->hydrate($db[$uuidString], Merchant::class);
    }

    public function save(Merchant $merchant): void
    {
        $db = $this->readJson();
        $db[$merchant->id()->toString()] = $this->hydrator->extract($merchant);
        if (file_put_contents($this->jsonFileLocation, json_encode($db, JSON_PRETTY_PRINT)) === false) {
            throw new \Exception('Failed to write JSON Database');
        }
    }
}
