# Nelsius Pay SDK for PHP & Laravel (V2)

[![Packagist Version](https://img.shields.io/packagist/v/nelsius/nelsius-pay-php.svg?style=flat-square)](https://packagist.org/packages/nelsius/nelsius-pay-php)
[![Total Downloads](https://img.shields.io/packagist/dt/nelsius/nelsius-pay-php.svg?style=flat-square)](https://packagist.org/packages/nelsius/nelsius-pay-php)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)

SDK officiel PHP & Laravel pour l'API **Nelsius Pay V2**. Acceptez simplement les paiements Mobile Money (Orange Money, MTN MoMo), cartes bancaires et virements dans toute l'Afrique.

---

## 📦 Installation

```bash
composer require nelsius/nelsius-pay-php
```

---

## ⚡ Utilisation avec Laravel

Ce package supporte l'**Auto-Discovery** de Laravel (Laravel 9, 10, 11+).

### 1. Configuration `.env`

Ajoutez vos clés d'API dans votre fichier `.env` :

```env
NELSIUS_PUBLIC_KEY=pk_live_xxxxxxxxxxxxxxxx
NELSIUS_SECRET_KEY=sk_live_xxxxxxxxxxxxxxxx
NELSIUS_WEBHOOK_SECRET=whsec_xxxxxxxxxxxx
```

Optionnel : publiez le fichier de configuration :
```bash
php artisan vendor:publish --tag=nelsius-config
```

### 2. Créer une session de paiement hébergée (Checkout)

```php
use Nelsius\Laravel\Facades\Nelsius;

$session = Nelsius::checkout()->createSession([
    'amount'            => 5000,
    'currency'          => 'XAF',
    'description'       => 'Paiement commande #4829',
    'customer_name'     => 'Alice Mbarga',
    'customer_email'    => 'alice@example.com',
    'customer_phone'    => '+237699112233',
    'default_country'   => 'CM', // Cameroun par défaut
    'allowed_countries' => ['CM', 'CI', 'SN'],
    'return_url'        => route('payment.success'),
    'cancel_url'        => route('payment.cancel'),
    'metadata'          => [
        'order_id' => 4829,
    ],
]);

// Redirigez l'utilisateur vers la page de paiement NelsiusPay :
return redirect($session['payment_url']);
```

---

## 🐘 Utilisation en PHP Vanilla

```php
require_once __DIR__ . '/vendor/autoload.php';

use Nelsius\NelsiusClient;

$client = new NelsiusClient('sk_live_xxxxxxxxxxxxxxxx');

// 1. Checkout Session
$session = $client->checkout->createSession([
    'amount'          => 2500,
    'currency'        => 'XAF',
    'customer_name'   => 'Paul Biya',
    'customer_email'  => 'paul@example.com',
    'default_country' => 'CM',
    'return_url'      => 'https://mon-site.com/succes',
    'cancel_url'      => 'https://mon-site.com/annule',
]);

header('Location: ' . $session['payment_url']);
exit;
```

### 2. Débit Direct Mobile Money (DirectPay)

```php
$charge = $client->charges->create([
    'amount'         => 1000,
    'currency'       => 'XAF',
    'payment_method' => 'orange_money', // 'orange_money' | 'mtn_momo'
    'phone_number'   => '699112233',
    'country'        => 'CM',
    'reference'      => 'TX-' . uniqid(),
]);

echo "Statut : " . $charge['status'];
```

---

## 🔒 Vérification des Webhooks

```php
use Nelsius\Utils\WebhookSignature;

$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_NELSIUS_SIGNATURE'] ?? '';
$secret    = 'whsec_xxxxxxxxxxxxxxxxxxxx';

if (!WebhookSignature::verify($payload, $signature, $secret)) {
    http_response_code(401);
    exit('Signature invalide');
}

$event = json_decode($payload, true);

if ($event['event'] === 'payment.success') {
    // Validez la commande du client
}
```

---

## 📄 Licence

MIT © [Nelsius](https://nelsiuspay.com)
