<?php

declare(strict_types=1);

namespace Billing\Infrastructure\Hydrator;

use Billing\Domain\Aggregate\Merchant;
use Ramsey\Uuid\Uuid;

/**
 * Class MerchantHydrator
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class MerchantHydrator extends BaseHydrator
{
    public function hydrate(array $data, $classNameOrObject)
    {
        $data['id'] = Uuid::fromString($data['id']);

        return parent::hydrate($data, $classNameOrObject);
    }

    /**
     * @param Merchant $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'id' => $object->id(),
            'name' => $object->name(),
        ];
    }
}
