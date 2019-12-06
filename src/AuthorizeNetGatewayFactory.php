<?php
declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class AuthorizeNetGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'authorize_net',
            'payum.factory_title' => 'Authorize.net'
        ]);
    }

}
