<?php

declare(strict_types=1);

namespace BenBorla\SyliusAuthorizeNetPlugin\StateMachine;

use Doctrine\Common\Collections\Collection;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Request\Capture;
use Payum\Core\Request\Refund;
use Payum\AuthorizeNet\Aim\AuthorizeNetAimGatewayFactory;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\OrderPaymentTransitions;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\StateResolver\StateResolverInterface;
use Webmozart\Assert\Assert;

final class Resolver implements StateResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(BaseOrderInterface $order): void
    {
        /** @var OrderInterface $order */
        Assert::isInstanceOf($order, OrderInterface::class);

        $targetTransition = $this->getTargetTransition($order);

        $lastPayment = $order->getLastPayment();
        if (null === $lastPayment) {
            return;
        }

        // Check if it's a QP payment
        $details = $lastPayment->getDetails();
        if (!isset($details['quickpayPaymentId'])) {
            return;
        }

        /** @var PaymentMethodInterface|null $paymentMethod */
        $paymentMethod = $lastPayment->getMethod();
        if (null === $paymentMethod) {
            return;
        }

        $gatewayConfig = $paymentMethod->getGatewayConfig();
        if (null === $gatewayConfig) {
            return;
        }

        $factory = new AuthorizeNetAimGatewayFactory();
        $gateway = $factory->create($gatewayConfig->getConfig());

        $model = new ArrayObject($details);

        [$totalPayed] = $this->getPaymentTotalWithState($order, PaymentInterface::STATE_COMPLETED);
        switch ($targetTransition) {
            case OrderPaymentTransitions::TRANSITION_PARTIALLY_PAY:
                $model['amount'] -= $totalPayed;
                if ($model['amount'] <= 0) {
                    return;
                }
                // no break
            case OrderPaymentTransitions::TRANSITION_PAY:
                $gateway->execute(new Capture($model));

                break;
            case OrderPaymentTransitions::TRANSITION_PARTIALLY_REFUND:
                [$totalRefunded] = $this->getPaymentTotalWithState($order, PaymentInterface::STATE_REFUNDED);
                $model['amount'] = $totalPayed - $totalRefunded;
                if ($model['amount'] <= 0) {
                    return;
                }
                // no break
            case OrderPaymentTransitions::TRANSITION_REFUND:
                $gateway->execute(new Refund($model));

                break;
        }
    }

    /**
     * @param OrderInterface|OrderInterface $order
     *
     * @return string|null
     */
    private function getTargetTransition(OrderInterface $order): ?string
    {
        [$refundedPaymentTotal, $refundedPayments] = $this->getPaymentTotalWithState($order, PaymentInterface::STATE_REFUNDED);

        if (0 < $refundedPayments->count() && $refundedPaymentTotal >= $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_REFUND;
        }

        if (0 < $refundedPaymentTotal && $refundedPaymentTotal < $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_PARTIALLY_REFUND;
        }

        [$completedPaymentTotal, $completedPayments] = $this->getPaymentTotalWithState($order, PaymentInterface::STATE_COMPLETED);

        if (
            (0 < $completedPayments->count() && $completedPaymentTotal >= $order->getTotal()) ||
            $order->getPayments()->isEmpty()
        ) {
            return OrderPaymentTransitions::TRANSITION_PAY;
        }

        if (0 < $completedPaymentTotal && $completedPaymentTotal < $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_PARTIALLY_PAY;
        }

        [$authorizedPaymentTotal, $authorizedPayments] = $this->getPaymentTotalWithState($order, PaymentInterface::STATE_AUTHORIZED);

        if (0 < $authorizedPayments->count() && $authorizedPaymentTotal >= $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_AUTHORIZE;
        }

        if (0 < $authorizedPaymentTotal && $authorizedPaymentTotal < $order->getTotal()) {
            return OrderPaymentTransitions::TRANSITION_PARTIALLY_AUTHORIZE;
        }

        return null;
    }

    /**
     * @param OrderInterface $order
     * @param string         $state
     *
     * @return Collection|PaymentInterface[]
     */
    private function getPaymentsWithState(OrderInterface $order, string $state): Collection
    {
        return $order->getPayments()->filter(function (PaymentInterface $payment) use ($state) {
            return $state === $payment->getState();
        });
    }

    /**
     * @param OrderInterface $order
     * @param string             $state
     *
     * @return array
     */
    private function getPaymentTotalWithState(OrderInterface $order, string $state): array
    {
        $paymentTotal = 0;
        $payments = $this->getPaymentsWithState($order, $state);

        foreach ($payments as $payment) {
            $paymentTotal += $payment->getAmount();
        }

        return [$paymentTotal, $payments];
    }
}
