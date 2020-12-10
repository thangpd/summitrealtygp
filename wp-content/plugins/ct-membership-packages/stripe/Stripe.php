<?php

// Tested on PHP 5.2, 5.3

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
  throw new Exception('Stripe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Stripe needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
  throw new Exception('Stripe needs the Multibyte String PHP extension.');
}

// Stripe singleton
require('stripe/Stripe.php');

// Utilities
require('stripe/Util.php');
require('stripe/Util/Set.php');

// Errors
require('stripe/Error.php');
require('stripe/ApiError.php');
require('stripe/ApiConnectionError.php');
require('stripe/AuthenticationError.php');
require('stripe/CardError.php');
require('stripe/InvalidRequestError.php');
require('stripe/RateLimitError.php');

// Plumbing
require('stripe/Object.php');
require('stripe/ApiRequestor.php');
require('stripe/ApiResource.php');
require('stripe/SingletonApiResource.php');
require('stripe/AttachedObject.php');
require('stripe/List.php');
require('stripe/RequestOptions.php');

// Stripe API Resources
require('stripe/Account.php');
require('stripe/Card.php');
require('stripe/Balance.php');
require('stripe/BalanceTransaction.php');
require('stripe/Charge.php');
require('stripe/Customer.php');
require('stripe/FileUpload.php');
require('stripe/Invoice.php');
require('stripe/InvoiceItem.php');
require('stripe/Plan.php');
require('stripe/Subscription.php');
require('stripe/Token.php');
require('stripe/Coupon.php');
require('stripe/Event.php');
require('stripe/Transfer.php');
require('stripe/Recipient.php');
require('stripe/Refund.php');
require('stripe/ApplicationFee.php');
require('stripe/ApplicationFeeRefund.php');
require('stripe/BitcoinReceiver.php');
require('stripe/BitcoinTransaction.php');
