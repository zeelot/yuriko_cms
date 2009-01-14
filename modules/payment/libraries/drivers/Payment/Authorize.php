<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Authorize.net Payment Driver
 *
 * $Id: Authorize.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Authorize_Driver implements Payment_Driver
{
	// Fields required to do a transaction
	private $required_fields = array
	(
		'x_login' => FALSE,
		'x_version' => TRUE,
		'x_delim_char' => TRUE,
		'x_url' => TRUE,
		'x_type' => TRUE,
		'x_method' => TRUE,
		'x_tran_key' => FALSE,
		'x_relay_response' => TRUE,
		'x_card_num' => FALSE,
		'x_expiration_date' => FALSE,
		'x_amount' => FALSE,
	);

	// Default required values
	private $authnet_values = array
	(
		'x_version'         => '3.1',
		'x_delim_char'      => '|',
		'x_delim_data'      => 'TRUE',
		'x_url'             => 'FALSE',
		'x_type'            => 'AUTH_CAPTURE',
		'x_method'          => 'CC',
		'x_relay_response'  => 'FALSE',
	);

	private $test_mode = TRUE;

	/**
	 * Sets the config for the class.
	 *
	 * @param  array  config passed from the library
	 */
	public function __construct($config)
	{
		$this->authnet_values['x_login'] = $config['auth_net_login_id'];
		$this->authnet_values['x_tran_key'] = $config['auth_net_tran_key'];
		$this->required_fields['x_login'] = !empty($config['auth_net_login_id']);
		$this->required_fields['x_tran_key'] = !empty($config['auth_net_tran_key']);

		$this->curl_config = $config['curl_config'];
		$this->test_mode = $config['test_mode'];

		Kohana::log('debug', 'Authorize.net Payment Driver Initialized');
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

			$this->authnet_values['x_'.$key] = $value;
			if (array_key_exists('x_'.$key, $this->required_fields) and !empty($value)) $this->required_fields['x_'.$key] = TRUE;
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

		$fields = '';
		foreach ( $this->authnet_values as $key => $value )
		{
			$fields .= $key.'='.urlencode($value).'&';
		}

		$post_url = ($this->test_mode) ?
					'https://certification.authorize.net/gateway/transact.dll' : // Test mode URL
					'https://secure.authorize.net/gateway/transact.dll'; // Live URL

		$ch = curl_init($post_url);

		// Set custom curl options
		curl_setopt_array($ch, $this->curl_config);

		// Set the curl POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, '& '));

		//execute post and get results
		$resp = curl_exec($ch);
		curl_close ($ch);
		if (!$resp)
			throw new Kohana_Exception('payment.gateway_connection_error');

		// This could probably be done better, but it's taken right from the Authorize.net manual
		// Need testing to opimize probably
		$h = substr_count($resp, '|');

		for ($j=1; $j <= $h; $j++)
		{
			$p = strpos($resp, '|');

			if ($p !== FALSE)
			{
				$pstr = substr($text, 0, $p);

				$pstr_trimmed = substr($pstr, 0, -1); // removes "|" at the end

				if ($pstr_trimmed=='')
				{
					throw new Kohana_Exception('payment.gateway_connection_error');
				}

				switch ($j)
				{
					case 1:
						if ($pstr_trimmed=='1') // Approved
							return TRUE;
						else
							return FALSE;
					default:
						return FALSE;
				}
			}
		}
	}
} // End Payment_Authorize_Driver Class