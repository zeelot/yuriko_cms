<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Trustcommerce Payment Driver
 *
 * $Id: Trustcommerce.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Trustcommerce_Driver implements Payment_Driver
{
	// Fields required to do a transaction
	private $required_fields = array
	(
		'custid' => TRUE,
		'password' => TRUE,
		'action' => TRUE,
		'media' => TRUE,
		'cc' => FALSE,
		'exp' => FALSE,
		'amount' => FALSE
	);

	private $tclink_library = './path/to/library';
	private $test_mode = TRUE;

	private $fields = array('demo' => 'n');

	/**
	 * Sets the config for the class.
	 *
	 * @param  array  config passed from the library
	 */
	public function __construct($config)
	{

		$this->test_mode = $config['test_mode'];
		$this->tclink_library = $config['tclink_library'];
		$this->fields['ip'] = $_SERVER['REMOTE_ADDR'];
		$this->fields['custid'] = $config['custid'];
		$this->fields['password'] = $config['password'];
		$this->fields['action'] = 'sale';
		$this->fields['media'] = $config['media'];

		if (!extension_loaded('tclink'))
		{
			if (!dl($this->tclink_library))
			{
				throw new Kohana_Exception('payment.no_dlib', $this->tclink_library);
			}
		}
		Kohana::log('debug', 'TrustCommerce Payment Driver Initialized');
	}

	public function set_fields($fields)
	{
		foreach ((array) $fields as $key => $value)
		{
			// Do variable translation
			switch ($key)
			{
				case 'card_num':
					$key = 'cc';
					break;
				case 'exp_date':
					$key = 'exp';
					if (strlen($value) == 3) $value = '0'.$value;
					break;
				case 'amount':
					$value = $value * 100;
					break;
				case 'address':
					$key = 'address1';
					break;
				case 'ship_to_address':
					$key = 'shipto_address1';
					break;
				case 'ship_to_city':
					$key = 'shipto_city';
					break;
				case 'ship_to_state':
					$key = 'shipto_state';
					break;
				case 'ship_to_zip':
					$key = 'shipto_zip';
					break;
				case 'cvv':
					$value = (int) $value;
					break;
				default:
					break;
			}

			$this->fields[$key] = $value;
			if (array_key_exists($key, $this->required_fields) and !empty($value))
			{
				$this->required_fields[$key] = TRUE;
			}
		}
	}

	public function process()
	{
		if ($this->test_mode)
			$this->fields['demo'] = 'y';

		$this->fields['name'] = $this->fields['first_name'].' '.$this->fields['last_name'];
		$this->fields['shipto_name'] = $this->fields['ship_to_first_name'].' '.$this->fields['ship_to_last_name'];
		unset($this->fields['first_name'], $this->fields['last_name'],$this->fields['ship_to_first_name'],$this->fields['ship_to_last_name']);

		// Check for required fields
		if (in_array(FALSE, $this->required_fields))
		{
			$fields = array();
			foreach ($this->required_fields as $key => $field)
			{
				if ( ! $field)
				{
					$fields[] = $key;
				}
			}
			throw new Kohana_Exception('payment.required', implode(', ', $fields));
		}

		$result = tclink_send($this->fields);

		// Report status
		if ($result['status'] == 'approved')
			return TRUE;
		elseif ($result['status'] == 'decline')
			return Kohana::lang('payment.error', 'payment_Trustcommerce.decline.'.$result[$result['status'].'type']);
		else
			return Kohana::lang('payment.error', Kohana::lang('payment_Trustcommerce.'.$result['status'].'.'.$result['error']));
	}
} // End Payment_Trustcommerce_Driver Class