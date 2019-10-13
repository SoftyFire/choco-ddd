<?php
declare(strict_types=1);

namespace Billing\Domain\Repository;

use Billing\Domain\Aggregate\Merchant;
use Ramsey\Uuid\UuidInterface;

interface MerchantRepositoryInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Merchant
     * @throws \OutOfBoundsException when Merchant was not found
     */
    public function getById(UuidInterface $uuid): Merchant;

    public function save(Merchant $merchant): void;
}
