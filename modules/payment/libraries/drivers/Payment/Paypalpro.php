<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Paypay (website payments pro) Payment Driver
 *
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Payment_Paypalpro_Driver implements Payment_Driver
{
	// Fields required to do a transaction

	/**
	* these are the required fields for the API method DoDirectPayment
	* other API methods and the associated fields required are listed here: http://tinyurl.com/2cffgr
	*
	* *note - paypalpro API field names are not case sensitive
	*/

	private $required_fields = array
	(

		'ENDPOINT'       => FALSE,
		'USER'           => FALSE,
		'PWD'            => FALSE,
		'SIGNATURE'      => FALSE,
		'VERSION'        => FALSE,

		'METHOD'         => FALSE,

		'PAYMENTACTION'  => FALSE,

		'CURRENCYCODE'   => FALSE, // default is USD - only required if other currency needed
		'AMT'            => FALSE, // payment amount

		'IPADDRESS'      => FALSE,

		'FIRSTNAME'      => FALSE,
		'LASTNAME'       => FALSE,

		'CREDITCARDTYPE' => FALSE,
		'ACCT'           => FALSE, // card number
		'EXPDATE'        => FALSE,
		'CVV2'           => FALSE

	);

	private $fields = array
	(

		'ENDPOINT'       => '',
		'USER'           => '',
		'PWD'            => '',
		'SIGNATURE'      => '',
		'VERSION'        => '',

		'METHOD'         => '',
		/* some possible values for METHOD :
		   'DoDirectPayment',
		   'RefundTransaction',
		   'DoAuthorization',
		   'DoReauthorization',
		   'DoCapture',
		   'DoVoid'
		*/

		'PAYMENTACTION'  => '',

		'CURRENCYCODE'   => '',
		'AMT'            => 0,  // payment amount

		'IPADDRESS'      => '',

		'FIRSTNAME'      => '',
		'LASTNAME'       => '',

		'CREDITCARDTYPE' => '',
		'ACCT'           => '', // card number
		'EXPDATE'        => '', // Format: MMYYYY
		'CVV2'           => '', // security code

		// -- OPTIONAL FIELDS --

		'STREET'         => '',
		'STREET2'        => '',
		'CITY'           => '',
		'STATE'          => '',
		'ZIP'            => '',
		'COUNTRYCODE'    => '',

		'SHIPTONAME'        => '',
		'SHIPTOSTREET'      => '',
		'SHIPTOSTREET2'     => '',
		'SHIPTOCITY'        => '',
		'SHIPTOSTATE'       => '',
		'SHIPTOZIP'         => '',
		'SHIPTOCOUNTRYCODE' => '',

		'INVNUM'         => '' // your internal order id / transaction id

		// other optional fields listed here:
		// https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/Appx_fieldreference.html#2145100
	);

	private $test_mode = TRUE;

	/**
	 * Sets the config for the class.
	 *
	 * @param : array  - config passed from the payment library constructor
	 */
	 
	public function __construct($config)
	{
		$this->test_mode = $config['test_mode'];

		if ($this->test_mode)
		{
			$this->fields['USER']         = $config['SANDBOX_USER'];
			$this->fields['PWD']          = $config['SANDBOX_PWD'];
			$this->fields['SIGNATURE']    = $config['SANDBOX_SIGNATURE'];
			$this->fields['ENDPOINT']     = $config['SANDBOX_ENDPOINT'];
		}
		else
		{
			$this->fields['USER']         = $config['USER'];
			$this->fields['PWD']          = $config['PWD'];
			$this->fields['SIGNATURE']    = $config['SIGNATURE'];
			$this->fields['ENDPOINT']     = $config['ENDPOINT'];
		}

		$this->fields['VERSION']      = $config['VERSION'];
		$this->fields['CURRENCYCODE'] = $config['CURRENCYCODE'];

		$this->required_fields['USER']         = !empty($config['USER']);
		$this->required_fields['PWD']          = !empty($config['PWD']);
		$this->required_fields['SIGNATURE']    = !empty($config['SIGNATURE']);
		$this->required_fields['ENDPOINT']     = !empty($config['ENDPOINT']);
		$this->required_fields['VERSION']      = !empty($config['VERSION']);
		$this->required_fields['CURRENCYCODE'] = !empty($config['CURRENCYCODE']);

		$this->curl_config = $config['curl_config'];

		Kohana::log('debug', 'Paypalpro Payment Driver Initialized');
	}

	/**
	*@desc set fields for nvp string
	*/

	public function set_fields($fields)
	{
		foreach ((array) $fields as $key => $value)
		{
			$this->fields[$key] = $value;

			if (array_key_exists($key, $this->required_fields) and !empty($value))
			{
				$this->required_fields[$key] = TRUE;
			}
		
		}
	}
	
	/**
	*@desc process PayPal Website Payments Pro transaction
	*/

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


		// Instantiate curl and pass the API post url
		$ch = curl_init($this->fields['ENDPOINT']);

		foreach ($this->fields as $key => $val)
		{
			// don't include unset optional fields in the name-value pair request string
			if ($val==='' OR $key=='ENDPOINT') unset($this->fields[$key]);
		}


		$nvp_qstr = http_build_query($this->fields);

		// Set custom curl options
		curl_setopt_array($ch, $this->curl_config);

		// Set the curl POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp_qstr);

		// Execute post and get results
		$response = curl_exec($ch);

		if (curl_errno($ch))
		{
			$curl_error_no  = curl_errno($ch);
			$curl_error_msg = curl_error($ch);
			throw new Kohana_Exception('curl.error:'.$curl_error_no.' - '.$curl_error_msg);
		}

		curl_close ($ch);

		if (!$response)
			throw new Kohana_Exception('payment.gateway_connection_error');


		$nvp_res_array = array();

		parse_str(urldecode($response),$nvp_res_array);

		return ($nvp_res_array['ACK'] == TRUE);

	}
} // End Payment_Paypalpro_Driver Class