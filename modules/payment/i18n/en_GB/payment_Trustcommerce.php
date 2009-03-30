<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'decline' => array
	(
		'avs' => 'AVS failed; the address entered does not match the billing address on file at the bank.',
		'cvv' => 'CVV failed; the number provided is not the correct verification number for the card.',
		'call' => 'The card must be authorised manually over the phone. You may choose to call the customer service number listed on the card and ask for an offline authcode, which can be passed in the offlineauthcode field.',
		'expiredcard' => 'The card has expired. Get updated expiration date from cardholder.',
		'carderror' => 'Card number is invalid, which could be a typo, or sometimes a card reported stolen.',
		'authexpired' => 'Attempt to postauth an expired (more than 14 days old) preauth.',
		'fraud' => 'CrediGuard fraud score was below requested threshold.',
		'blacklist' => 'CrediGuard blacklist value was triggered.',
		'velocity' => 'CrediGuard velocity control was triggered.',
		'dailylimit' => 'Daily limit in transaction count or amount as been reached.',
		'weeklylimit' => 'Weekly limit in transaction count or amount as been reached.',
		'monthlylimit' => 'Monthly limit in transaction count or amount as been reached.',
	),
	'baddata' => array
	(
		'missingfields' => 'One or more parameters required for this transaction type were not sent.',
		'extrafields' => 'Parameters not allowed for this transaction type were sent.',
		'badformat' => 'A field was improperly formatted, such as non-digit characters in a number field.',
		'badlength' => 'A field was longer or shorter than the server allows.',
		'merchantcantaccept' => 'The merchant can\'t accept data passed in this field.',
		'mismatch' => 'Data in one of the offending fields did not cross-check with the other offending field.',
	),
	'error' => array
	(
		'cantconnect' => 'Couldn\'t connect to the TrustCommerce gateway. Check your Internet connection to make sure it is up.',
		'dnsfailure' => 'The TCLink software was unable to resolve DNS hostnames. Make sure you have name resolving ability on the machine.',
		'linkfailure' => 'The connection was established, but was severed before the transaction could complete.',
		'failtoprocess' => 'The bank servers are offline and unable to authorise transactions. Try again in a few minutes, or try a card from a different issuing bank.',
	)
);