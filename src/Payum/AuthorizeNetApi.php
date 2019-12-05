<?php

declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin\Payum;

final class AuthorizeNetApi
{
    /** @var string */
    private $loginId;

    /**
     * @var string
     */
    private $transactionKey;

    public function __construct(string $loginId, string $transactionKey)
    {
        $this->loginId = $loginId;
        $this->transactionKey = $transactionKey;
    }

    /**
     * @return string
     */
    public function getLoginId(): string
    {
        return $this->loginId;
    }

    public function getTransactionKey(): string
    {
        return $this->transactionKey;
    }
}
