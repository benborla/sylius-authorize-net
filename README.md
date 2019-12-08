[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

# Authorize.net Payment plugin for Sylius

This plugin adds Authorize.net as a payment option to Sylius.

## Installation

### 1. Install plugin
 
```bash
$ composer require benborla/authorize-net-plugin
```

### 2. Make sure the plugin is added to `bundles.php`:

```php
# config/bundles.php
        BenBorla\SyliusAuthorizeNetPlugin\BenBorlaSyliusAuthorizeNetPlugin::class => ['all' => true],
```

### 3. Import the config file

```yaml
# config/packages/_sylius.yaml
imports:
    - { resource: "@BenBorlaSyliusAuthorizeNetPlugin/Resources/config/app/config.yaml" }
```

### 4. (Optional) Import fixtures to play in your app

````yaml
# config/packages/_sylius.yaml
imports:
    - { resource: "@BenBorlaSyliusAuthorizeNetPlugin/Resources/config/app/fixtures.yaml" }    
````

## Configuration

Create a new Payment method of the type *Authorize.net* and fill out the required form fields.

## Testing

### Automated tests

Run `composer tests`

### Manual testing

- Use credit card numbers from https://developer.authorize.net/hello_world/testing_guide/
