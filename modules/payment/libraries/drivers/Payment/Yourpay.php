<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Yourpay Payment Driver
 *
 * $Id: Yourpay.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Yourpay_Driver implements Payment_Driver
{
	// Fields required to do a transaction
	private $required_fields = array
	(
		'card_num' => FALSE,
		'expiration_date' => FALSE,
		'amount' => FALSE,
		'tax' => FALSE,
		'shipping' => FALSE,
		'cvm_value' => FALSE
	);

	// Default required values
	private $fields = array
	(
		'card_num' => '',
		'expiration_date' => '',
		'cvm_value' => '',
		'amount' => 0,
		'tax' => 0,
		'shipping' => 0,
		'billing_name' => '',
		'billing_address' => '',
		'billing_city' => '',
		'billing_state' => '',
		'billing_zip' => '',
		'shipping_name' => '',
		'shipping_address' => '',
		'shipping_city' => '',
		'shipping_state' => '',
		'shipping_zip' => ''
	);

	// The location of the certficate file. Set from the config
	private $certificate = './path/to/certificate';
	private $test_mode = TRUE;

	/**
	 * Sets the config for the class.
	 *
	 * @param  array  config passed from the library
	 */
	public function __construct($config)
	{
		// Check to make sure the certificate is valid
		$this->certificate = is_file($config['certificate']) ? $config['certificate'] : FALSE;

		if (!$this->certificate)
			throw new Kohana_Exception('payment.invalid_certificate', $config['certificate']);

		$this->curl_config = $config['curl_config'];
		$this->test_mode = $config['test_mode'];

		Kohana::log('debug', 'YourPay.net Payment Driver Initialized');
	}

	public function set_fields($fields)
	{
		foreach ((array) $fields as $key => $value)
		{
			// Do variable translation
			switch ($key)
			{
				case 'exp_date':
					$key = 'expiration_date';
					break;
				default:
					break;
			}

			$this->fields[$key] = $value;
			if (array_key_exists($key, $this->required_fields) and !empty($value)) $this->required_fields[$key] = TRUE;
		}
	}

	public function process()
	{
		// Check for required fields
		if (in_array(FALSE, $this->required_fields))
		{
			$fields = array();
			foreach ($this->required_fields as $key => $field)
			{
				if (!$field) $fields[] = $key;
			}
			throw new Kohana_Exception('payment.required', implode(', ', $fields));
		}

		$xml ='<order>
				<orderoptions>
					<ordertype>SALE</ordertype>
					<result>'.($this->test_mode) ? 'GOOD' : 'LIVE'.'</result>
				</orderoptions>
				<merchantinfo>
					<configfile>'.$this->config['merchant_id'].'</configfile>
				</merchantinfo>
				<creditcard>
					<cardnumber>'.$this->fields['card_num'].'</cardnumber>
					<cardexpmonth>'.substr($this->fields['expiration_date'], 0, 2).'</cardexpmonth>
					<cardexpyear>'.substr($this->fields['expiration_date'], 2, 2).'</cardexpyear>
					<cvmvalue>'.$this->fields['cvm_value'].'</cvmvalue>
				</creditcard>
				<payment>
					<subtotal>'.$this->fields['amount'].'</subtotal>
					<tax>'.$this->fields['tax'].'</tax>
					<shipping>'.$this->fields['shipping'].'</shipping>
					<chargetotal>'.($this->fields['amount'] + $this->fields['tax'] + $this->fields['shipping']).'</chargetotal>
				</payment>
				<billing>
					<name>'.$this->fields['billing_name'].'</name>
					<address1>'.$this->fields['billing_address'].'</address1>
					<city>'.$this->fields['billing_city'].'</city>
					<state>'.$this->fields['billing_state'].'</state>
					<zip>'.$this->fields['billing_zip'].'</zip>
					<email>'.$this->fields['email'].'</email>
				</billing>
				<shipping>
					<name>'.$this->fields['shipping_name'].'</name>
					<address1>'.$this->fields['shipping_address'].'</address1>
					<city>'.$this->fields['shipping_city'].'</city>
					<state>'.$this->fields['shipping_state'].'</state>
					<zip>'.$this->fields['shipping_zip'].'</zip>
				</shipping>
			</order>';

		$post_url = 'https://secure.linkpt.net:1129/LSGSXML';

		$ch = curl_init($post_url);

		// Set custom curl options
		curl_setopt_array($ch, $this->curl_config);
		curl_setopt ($ch, CURLOPT_SSLCERT, $this->certificate);

		// Set the curl POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

		if ($result = curl_exec ($ch))
		{
			if (strlen($result) < 2) # no response
				throw new Kohana_Exception('payment.gateway_connection_error');

			// Convert the XML response to an array
			preg_match_all ("/<(.*?)>(.*?)\</", $result, $outarr, PREG_SET_ORDER);
			$n = 0;
			while (isset($outarr[$n]))
			{
				$retarr[$outarr[$n][1]] = strip_tags($outarr[$n][0]);
				$n++;
			}

			if ($retarr['r_approved'] == "APPROVED") // SUCCESS
			{
				return true;
			}
			else // FAILURE... =(
			{
				$error = explode(":", $retarr['r_error']);
				return $error[1];
			}
		}
		else
			throw new Kohana_Exception('payment.gateway_connection_error');
	}
} // End Payment_Yourpay_Driver Class