<?php
declare(strict_types=1);

namespace Billing\Domain\Aggregate;

use Billing\Domain\Support\ObjectEventsTrait;
use DateTimeImmutable;
use Finite\State\StateInterface;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class Order
{
    use ObjectEventsTrait;

    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var Merchant
     */
    private $merchant;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Money
     */
    private $amount;

    /**
     * @var DateTimeImmutable
     */
    private $createTime;

    /**
     * @var StateInterface
     */
    private $status;

    public static function create(OrderCreationDto $dto): self
    {
        $self = new self();

        return $self;
    }

    public function startProcessing(DateTimeImmutable $time, PaymentMethodSelector $paymentMethodSelector): void
    {
        return;

        // TODO: implement
        $paymentMethod = $paymentMethodSelector->__invoke($this);
        $this->registerThat(OrderPaymentMethodWasChoosen::occured($this, $paymentMethod));

        $this->changeStatus('processing');
        $this->registerThat(OrderStateWasChange::occured($this, $state));
    }
}
//
////
//
//$order->state = 'processing';
//$order->lastUpdateTime = new DateTimeImmutable();
//$order->paymentGateway = $this->choosePaymentGatewatForCustomer($customer, $order);
//
//// ----
//
//$paymentMethodSelector = $this->di->get(PaymentMethodSelector::class);
//$order->startProcessing(new DateTimeImmutable(), $paymentMethodSelector);
