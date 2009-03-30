<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * @package  Payment
 *
 * Settings related to the Payment library.
 * This file has settings for each driver.
 * You should copy the 'default' and the specific
 * driver you are working with to your application/config/payment.php file.
 *
 * Options:
 *  driver - default driver to use
 *  test_mode - Turn TEST MODE on or off
 *  curl_settings - Set any custom cURL settings here. These defaults usualy work well.
 *                  see http://us.php.net/manual/en/function.curl-setopt.php for details
 */
$config['default'] = array
(
	'driver'        => 'Authorize',
	'test_mode'     => TRUE,
	'curl_config'   => array(CURLOPT_HEADER         => FALSE,
	                         CURLOPT_RETURNTRANSFER => TRUE,
	                         CURLOPT_SSL_VERIFYPEER => FALSE)
);

/**
 * Authorize.net Options:
 *  auth_net_login_id - the transaction login ID; provided by gateway provider
 *  auth_net_tran_key - the transaction key; provided by gateway provider
 */
$config['Authorize'] = array
(
	'auth_net_login_id' => '',
	'auth_net_tran_key' => ''
);

/**
 * YourPay.net Options:
 *  merchant_id - the merchant ID number
 *  certificate - the location on your server of the certificate file.
 */
$config['Yourpay'] = array
(
	'merchant_id' => '',
	'certificate' => './path/to/certificate.pem'
);

/**
 * TrustCommerce Options:
 *  custid - the customer ID assigned to you by TrustCommerce
 *  password - the password assigned to you by TrustCommerce
 *  media - "cc" for credit card or "ach" for ACH.
 *  tclink_library - the location of the tclink library (relative to your index file) you need to compile to get this driver to work.
 */
$config['Trustcommerce'] = array
(
	'custid' => '',
	'password' => '',
	'media' => 'cc',
	'tclink_library' => './path/to/library.so'
);

/**
 * TridentGateway Options:
 *  profile_id - the profile ID assigned to you by Merchant e-Services
 *  profile_key - the profile password assigned to you by Merchant e-Services
 *  transaction_type - D=Sale, C=Credit, P=Pre-Auth, O=Offline, V-Void, S=Settle Pre-Auth, U=Refund, T= Store card data., X=Delete Card Store Data
 */
$config['Trident'] = array
(
	'profile_id' => '',
	'profile_key' => '',
	'transaction_type' => 'D'
);

/**
 * PayPal Options:
 *  API_UserName - the username to use
 *  API_Password - the password to use
 *  API_Signature - the api signature to use
 *  ReturnUrl - the URL to send the user to after they login with paypal
 *  CANCELURL - the URL to send the user to if they cancel the paypal transaction
 *  CURRENCYCODE - the Currency Code to to the transactions in (What do you want to get paid in?)
 */
$config['Paypal'] = array
(
	'USER'         => '-your-paypal-api-username',
	'PWD'          => '-your-paypal-api-password',
	'SIGNATURE'    => '-your-paypal-api-security-signiature',
	'ENDPOINT'     => 'https://api-3t.paypal.com/nvp',

	'RETURNURL'     => 'http://yoursite.com',
	'CANCELURL'     => 'http://yoursite.com/canceled',

	// -- sandbox authorization details are generic
	'SANDBOX_USER'      => 'sdk-three_api1.sdk.com',
	'SANDBOX_PWD'       => 'QFZCWN5HZM8VBG7Q',
	'SANDBOX_SIGNATURE' => 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI',
	'SANDBOX_ENDPOINT'  => 'https://api-3t.sandbox.paypal.com/nvp',

	'VERSION'      => '3.2',
	'CURRENCYCODE' => 'USD',
);

/**
 * PayPalpro Options:
 *  USER      - API user name to use
 *  PWD       - API password to use
 *  SIGNATURE - API signature to use
 *
 *  ENDPOINT  - API url used by live transaction
 *
 *  SANDBOX_USER      - User name used in test mode
 *  SANDBOX_PWD       - Pass word used in test mode
 *  SANDBOX_SIGNATURE - Security signiature used in test mode
 *  SANDBOX_ENDPOINT  - API url used for test mode transaction
 *
 *  VERSION   - API version to use
 *  CURRENCYCODE - can only currently be USD
 *
 */
$config['Paypalpro'] = array
(

	'USER'         => '-your-paypal-api-username',
	'PWD'          => '-your-paypal-api-password',
	'SIGNATURE'    => '-your-paypal-api-security-signiature',
	'ENDPOINT'     => 'https://api-3t.paypal.com/nvp',

	// -- sandbox authorization details are generic
	'SANDBOX_USER'      => 'sdk-three_api1.sdk.com',
	'SANDBOX_PWD'       => 'QFZCWN5HZM8VBG7Q',
	'SANDBOX_SIGNATURE' => 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI',
	'SANDBOX_ENDPOINT'  => 'https://api-3t.sandbox.paypal.com/nvp',

	'VERSION'      => '3.2',
	'CURRENCYCODE' => 'USD',

	'curl_config'  => array
	(
		CURLOPT_HEADER         => FALSE,
		CURLOPT_SSL_VERIFYPEER => FALSE,
		CURLOPT_SSL_VERIFYHOST => FALSE,
		CURLOPT_VERBOSE        => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_POST           => TRUE
	)

);

/**
 * GoogleCheckoutGateway Options:
 *  google_API_key - the profile ID assigned to you by Merchant e-Services
 *  google_merchant_id - the profile password assigned to you by Merchant e-Services
 *  google_sandbox_API_key - D=Sale, C=Credit, P=Pre-Auth, O=Offline, V-Void, S=Settle Pre-Auth, U=Refund, T= Store card data., X=Delete Card Store Data
 */
$config['GoogleCheckout'] = array
(
	'google_API_key'					=> '-your-google-checkout-api-key',
	'google_merchant_id'				=> '-your-google-checkout-merchant-id',
	'google_sandbox_API_key'			=> '-your-google-checkout-sandbox-api-key',
	'google_sandbox_merchant_id'		=> '-your-google-checkout-sandbox-merchant-id',
	'currency_code'						=> 'USD',
	'action'							=> '',
	'xml_body'							=> '',
	'test_mode'							=> false,
	'curl_config'  						=> array
	(
		CURLOPT_HEADER					=> FALSE,
		CURLOPT_SSL_VERIFYPEER			=> FALSE,
		CURLOPT_SSL_VERIFYHOST			=> FALSE,
		CURLOPT_VERBOSE					=> TRUE,
		CURLOPT_RETURNTRANSFER			=> TRUE,
		CURLOPT_POST					=> TRUE
	)
);

/**
 * Moneybookers Options:
 * Full api documentation available from https://www.moneybookers.com/app/help.pl?s=m_manual
 */
$config['MoneyBookers'] = array
(
	'payment_url'			=> 'https://www.moneybookers.com/app/',
	'payment_script'		=> 'payment.pl',
	'query_script'			=> 'query.pl',
	'ondemand_script'		=> 'ondemand_request.pl',
	'refund_script'			=> 'refund.pl',
	'test_payment_script'	=> 'test_payment.pl',
	'pay_to_email'  		=> 'your@email.address',
	'logo_url' 				=> '',
	'transaction_id'  		=> '',
	'pay_to_email'			=> '',
	'password'				=> '',
	'test_pay_to_email'		=> 'your@test.email.address',
	'test_password'			=> '',
	'return_url'  			=> '',
	'status_url'  			=> '',
	'cancel_url'  			=> '',
	'recipient_description' => '',
	'hide_login' 			=> '1',
	'language'  			=> 'EN',
	'amount' 		    	=> '',
	'currency' 		    	=> 'USD',
	'ondemand_max_amount'	=> '600',
	'ondemand_max_currency'	=> 'USD',
	'ondemand_note'			=> 'For faster transactions for future payments, accept on demand payment as an option.',
	'test_mode'				=> false,
	'payment_methods'		=> '',
	'payment_method_types'		=> array
	(
		'UK' => array('VSD' => 'Visa Delta/Debit', 'MAE' => 'Maestro', 'SLO' => 'Solo'),
		'US' => array('WLT' => 'Bank'),
		'DE' => array('GIR' => 'Giropay', 'DID' => 'Direct Debit', 'SFT' => 'Sofortueberweisung', 'WLT' => 'Bank'),
		'AU' => array('PLI' => 'POLi', 'WLT' => 'Bank'),
		'NZ' => array('WLT' => 'Bank'),
		'ZA' => array('WLT' => 'Bank'),
		'IE' => array('LSR' => 'Laser', 'WLT' => 'Bank'),
		'NL' => array('IDL' => 'iDeal', 'WLT' => 'Bank'),
		'AT' => array('NPY' => 'Netpay', 'WLT' => 'Bank'),
		'SE' => array('EBT' => 'Norda Solo', 'WLT' => 'Bank'),
		'SG' => array('ENT' => 'eNets', 'WLT' => 'Bank'),
	),
	'curl_config'  => array
	(
		CURLOPT_HEADER         => FALSE,
		CURLOPT_SSL_VERIFYPEER => FALSE,
		CURLOPT_SSL_VERIFYHOST => FALSE,
		CURLOPT_VERBOSE        => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_POST           => TRUE
	)
);
