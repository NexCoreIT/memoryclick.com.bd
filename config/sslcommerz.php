<?php

// SSLCommerz configuration dynamically fetched from database settings with .env fallback
$setting = null;
try {
    if (class_exists(\Illuminate\Support\Facades\DB::class)) {
        $setting = \Illuminate\Support\Facades\DB::table('home_page_contents')->first();
    }
} catch (\Throwable $e) {}

$isSandbox = isset($setting->ssl_sandbox) ? (bool)$setting->ssl_sandbox : (bool)env('SSLCZ_TESTMODE', true);
$storeId = (!empty($setting->ssl_store_id)) ? $setting->ssl_store_id : env("SSLCZ_STORE_ID");
$storePass = (!empty($setting->ssl_store_password)) ? $setting->ssl_store_password : env("SSLCZ_STORE_PASSWORD");

$apiDomain = $isSandbox ? "https://sandbox.sslcommerz.com" : "https://securepay.sslcommerz.com";

return [
	'apiCredentials' => [
		'store_id' => $storeId,
		'store_password' => $storePass,
	],
	'apiUrl' => [
		'make_payment' => "/gwprocess/v4/api.php",
		'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
		'order_validate' => "/validator/api/validationserverAPI.php",
		'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
		'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
	],
	'apiDomain' => $apiDomain,
	'connect_from_localhost' => $isSandbox,
	'success_url' => '/success',
	'failed_url' => '/fail',
	'cancel_url' => '/cancel',
	'ipn_url' => '/ipn',
];
