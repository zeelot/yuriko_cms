<?php defined('SYSPATH') or die('No direct script access.');
/**
 * MoneyBookers Payment Driver
 *
 * $Id: MoneyBookers.php
 *
 * @package    Payment
 * @author     Josh Domagala
 * @copyright  (c) 2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Moneybookers_Driver implements Payment_Driver
{
	// Fields required to do a transaction
	private $required_fields = array
	(
		'payment_url'	=> FALSE,
		'script'	=> FALSE,
		'currency'	=> FALSE,
		'pay_to_email'			=> FALSE,
		'test_pay_to_email'			=> FALSE,
		'password'		=> FALSE,
		'test_password'		=> FALSE,
		'postdata'              => FALSE,
		'action'              => FALSE
	);

	private $fields = array
	(
		'payment_url'	=> '',
		'script'	=> '',
		'currency'	=> '',
		'pay_to_email'	=> '',
		'test_pay_to_email'	=> '',
		'password'		=> '',
		'test_password'		=> '',
		'postdata'		=> '',
		'action'		=> '',
		'trn_id'        => '',
		'mb_trn_id'        => '',
		'rec_payment_id'        => '',
		'sid'        => ''
	);

	private $test_mode = TRUE;

	/**
	 * Sets the config for the class.
	 *
	 * @param  array  config passed from the library
	 */
	public function __construct($config)
	{
		$this->test_mode = $config['test_mode'];
		
		$this->fields['payment_url'] = $config['payment_url'];
		$this->fields['currency'] = $config['currency'];
		
		if($this->test_mode)
		{
			$this->fields['test_pay_to_email'] = $config['test_pay_to_email'];
			$this->fields['test_password'] = $config['test_password'];
		}
		else
		{
			$this->fields['pay_to_email'] = $config['pay_to_email'];
			$this->fields['password'] = $config['password'];
		}
		
		$this->curl_config = $config['curl_config'];

		Kohana::Log('debug', 'MoneyBookers Payment Driver Initialized');
	}

	public function set_fields($fields)
	{
		foreach ((array) $fields as $key => $value)
		{
			$this->fields[$key] = $value;
			if ( array_key_exists( $key, $this->required_fields ) and !empty( $value ) )
			{
				$this->required_fields[$key] = TRUE;
			} 
		}
	}

	public function process()
	{	
		$post_url = ($this->test_mode)
		          ? $this->fields['payment_url'].$this->fields['script'] // Test mode URL
		          : $this->fields['payment_url'].$this->fields['script']; // Live URL
		          
		$pay_to_email = ($this->test_mode)
		          ? $this->fields['test_pay_to_email'] // Test mode email
		          : $this->fields['pay_to_email']; // Live email
		          
		$password = ($this->test_mode)
		          ? $this->fields['test_password'] // Test mode password
		          : $this->fields['password']; // Live password

		$this->fields['postdata']['action'] = $this->fields['action'];
		
		$config = Kohana::config('payment.MoneyBookers');

		if($this->fields['script'] == $config['refund_script'] && $this->fields['action'] == "prepare")
		{
			$this->fields['postdata']['email'] = $pay_to_email;
			$this->fields['postdata']['password'] = md5($password);
			$this->fields['postdata']['trn_id'] = $this->fields['trn_id'];
		}
		elseif($this->fields['action'] == "prepare")
		{
			$this->fields['postdata']['email'] = $pay_to_email;
			$this->fields['postdata']['password'] = md5($password);
			$this->fields['postdata']['amount'] = $this->fields['amount'];
			$this->fields['postdata']['currency'] = $this->fields['currency'];
			$this->fields['postdata']['frn_trn_id'] = $this->fields['trn_id'];
			$this->fields['postdata']['rec_payment_id'] = $this->fields['rec_payment_id'];
		}
		elseif($this->fields['action'] == "refund")
		{
			$this->fields['postdata']['sid'] = $this->fields['sid'];
		}
		elseif($this->fields['action'] == "request")
		{
			$this->fields['postdata']['sid'] = $this->fields['sid'];
		}
		elseif($this->fields['action'] == "status_od")
		{
			$this->fields['postdata']['email'] = $pay_to_email;
			$this->fields['postdata']['password'] = md5($password);
			$this->fields['postdata']['trn_id'] = $this->fields['trn_id'];
		}
		elseif($this->fields['action'] == "status_trn")
		{
			$this->fields['postdata']['email'] = $pay_to_email;
			$this->fields['postdata']['password'] = md5($password);
			$this->fields['postdata']['mb_trn_id'] = $this->fields['trn_id'];
		}

		$ch = curl_init($post_url);

		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		// the following disallows redirects
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		// next we return into a variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, 1);

		// Set the curl POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields['postdata']);

		// Execute post and get results
		$response = curl_exec($ch);
		// Get error messages.
		$info = curl_getinfo($ch);

		curl_close ($ch);

		if(!$response)
		{
			return false;
		}
			
		if($this->fields['action'] != "status_od" && $this->fields['action'] != "status_trn")
		{
			$xml = simplexml_load_string($response);
		}
			
		if($this->fields['action'] == "prepare")
		{
			return ($xml->{'sid'} != "") ? $xml : false;
		}
			
		if($this->fields['action'] == "request")
		{
			return ($xml->{'transaction'}->{'status_msg'} == "processed") ? $xml : false;
		}
			
		if($this->fields['action'] == "status_od")
		{
			return (strstr($response, "Status: 0")) ? true : false;
		}
		
		if($this->fields['action'] == "status_trn")
		{
			return (strstr($response, "OK")) ? $response : false;
		}
		
		if($this->fields['action'] == "refund")
		{
			return ($xml->{'status'} == 2) ? $xml : false;
		}
	}
} // End Payment_MoneyBookers_Driver Class