# Sylius Authorize.net payment gateway plugin  
<div align="center">
    <a href="http://sylius.com" title="Sylius" target="_blank"><img src="https://demo.sylius.com/assets/shop/img/logo.png" width="300" /></a>
    <br />
    [Authorize.net logo here]
</div>

## Installation

```bash
$ composer require benborla/authorize-net-plugin
```
    
Add plugin dependencies to your bundles.php file:

```php
    return [
    ...
        BenBorla\SyliusAuthorizeNetPlugin\BenBorlaSyliusAuthorizeNetPlugin::class => ['all' => true],
    ];
```

## Usage
Add your test credentials in Sylius admin as new payment method. Complete couple
of orders with different states and send email to Authorize.net authorities. 
After the review you will get production credentials, so just change it in Sylius admin and you are ready to go. 

