<?php
declare(strict_types=1);

namespace spec\BenBorla\SyliusAuthorizeNetPlugin\Exception;

use PhpSpec\ObjectBehavior;
use BenBorla\SyliusAuthorizeNetPlugin\Exception\UnsupportedPaymentTransitionException;

final class UnsupportedPaymentTransitionExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UnsupportedPaymentTransitionException::class);
    }

    public function it_is_an_exception_exception(): void
    {
        $this->shouldHaveType(\Exception::class);
    }
}
