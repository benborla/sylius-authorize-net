<?php
declare(strict_types=1);

namespace BenBorla\AuthorizeNetPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;
/**
 * @author Ben Borla <benborla@icloud.com>
 */
final class BenBorlaAuthorizeNetPlugin extends Bundle {
	// attach Sylius Plugin Trait
    use SyliusPluginTrait;
}
