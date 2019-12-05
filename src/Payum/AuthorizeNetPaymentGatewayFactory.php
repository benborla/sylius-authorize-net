<?php

declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin\Payum;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use BenBorla\AuthorizeNetPlugin\Payum\AuthorizeNetApi;

final class AuthorizeNetPaymentGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'authorize_net',
            'payum.factory_title' => 'Authorize.net',
        ]);

        $config['payum.api'] = function (ArrayObject $config) {
            return new AuthorizeNetApi($config['login_id'], $config['transaction_key']);
        };
    }
}
