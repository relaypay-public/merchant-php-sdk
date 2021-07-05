# RelayPay PHP SDK

This package provides an official PHP SDK to interact with the RelayPay API. 

## Installation

Use Composer to install the package:
`composer require relaypay/php-sdk`

## Quick start
Setup the client:

```$rp = new RelayPay( 'YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'YOUR_EMAIL' );```

Call the API:

```$transactions = $rp->ecommerce()->getTransactions();```

For more examples review the `Examples` folder.