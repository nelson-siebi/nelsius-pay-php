# Nelsius PHP SDK

Official PHP SDK for the [Nelsius Developer API](https://nelsius.com/docs).

## Installation

```bash
composer require nelsius/nelsius-php
```

*Note: For manual installation, require the files in `src/`.*

## Quick Start

```php
use Nelsius\NelsiusClient;

$nelsius = new NelsiusClient('your_secret_key', [
    'base_url' => 'https://api.nelsius.com/api/v1'
]);

// 1. Get Payment Methods
$methods = $nelsius->charges->methods();

// 2. Create Hosted Checkout Session
$checkout = $nelsius->checkout->createSession([
    'amount' => 5000,
    'currency' => 'XAF',
    'reference' => 'ORDER_12345',
    'description' => 'Purchase Description',
    'return_url' => 'https://your-site.com/success',
    'cancel_url' => 'https://your-site.com/cancel',
    'customer' => [
        'email' => 'customer@example.com',
        'name' => 'Customer Name'
    ]
]);

header('Location: ' . $checkout['data']['checkout_url']);

// 3. Create Direct Charge (Mobile Money)
$charge = $nelsius->charges->create([
    'amount' => 2500,
    'currency' => 'XAF',
    'method' => 'mobile_money',
    'operator' => 'orange',
    'customer_phone' => '690000000',
    'reference' => 'TXN_REF_001'
]);
```

## Features

- **Charges**: Direct payment processing (Mobile Money, Crypto, etc.)
- **Checkout**: Hosted payment pages for easier integration.
- **Balance**: Check your merchant account balance programmatically.
- **Payment Methods**: Retrieve supported payment methods dynamically.

## License

MIT
