<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Google Checkout Payment Driver
 *
 * $Id: GoogleCheckout.php 1938 2008-08-03 Domics $
 *
 * @package    Payment
 * @author     Josh Domagala
 * @copyright  (c) 2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Googlecheckout_Driver implements Payment_Driver
{
	// Fields required to do a transaction
	private $required_fields = array
	(
		'action'			=> FALSE,
		'xml_body'			=> FALSE
	);

	private $fields = array
	(
		'google_API_key'				=> '',
		'google_merchant_id'			=> '',
		'google_sandbox_API_key'		=> '',
		'google_sandbox_merchant_id'	=> '',
		'action'						=> '',
		'xml_body'						=> ''
	);

	private $test_mode = TRUE;

	/**
	 * Sets the config for the class.
	 *
	 * @param  array  config passed from the library
	 */
	public function __construct($config)
	{
		$this->fields['google_API_key'] = $config['google_API_key'];
		$this->fields['google_merchant_id'] = $config['google_merchant_id'];
		$this->fields['google_sandbox_API_key'] = $config['google_sandbox_API_key'];
		$this->fields['google_sandbox_merchant_id'] = $config['google_sandbox_merchant_id'];
		
		$this->curl_config = $config['curl_config'];
		$this->test_mode = $config['test_mode'];
		
		if($this->test_mode)
		{
			$base64encoding = base64_encode($this->fields['google_sandbox_merchant_id'].":".$this->fields['google_sandbox_API_key']);
		}
		else
		{
			$base64encoding = base64_encode($this->fields['google_merchant_id'].":".$this->fields['google_API_key']);
		}
			
		$this->xml_header = array("Authorization: Basic ".$base64encoding, "Content-Type: application/xml;charset=UTF-8", "Accept: application/xml;charset=UTF-8");

		Kohana::Log('debug', 'Google Checkout Payment Driver Initialized');
	}

	public function set_fields($fields)
	{
		foreach ((array) $fields as $key => $value)
		{
			$this->fields[$key] = $value;
			if (array_key_exists($key, $this->required_fields) and !empty($value)) $this->required_fields[$key] = TRUE;
		}
	}

	/**
	 * Used to process any xml requests
	 * 
	 * @return (string) xml string
	 */
	public function process()
	{
		$post_url = ($this->test_mode)
	    	      ? 'https://sandbox.google.com/checkout/api/checkout/v2/'.$this->fields['action'].'/Merchant/'.$this->fields['google_sandbox_merchant_id'] // Test mode URL
	        	  : 'https://checkout.google.com/api/checkout/v2/'.$this->fields['action'].'/Merchant/'.$this->fields['google_merchant_id']; // Live URL

		$ch = curl_init($post_url);

		//Set the curl config
		curl_setopt_array($ch, $this->curl_config);
		// Set custom curl options
		curl_setopt($ch, CURLOPT_POST, true);

		// Set the curl POST fields
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->xml_header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields['xml_body']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Execute post and get results
		$response = curl_exec($ch);
		curl_close ($ch);

		// Return a response if there was one
		return (!empty($response)) ? $response : Kohana::lang('payment.error', Kohana::lang('payment_GoogleCheckout.'.$response['error_code']));
	}
} // End Payment_GoogleCheckout_Driver Class