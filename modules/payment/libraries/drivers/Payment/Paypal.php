<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Paypal Payment Driver. Express Checkout transactions consist of 3 stages with
 * a separate API call for each: SetExpressCheckout, GetExpressCheckout (optional)
 * and DoExpressCheckout. This class has a corresponding array of fields for each
 * call these are used to construct the required name value pairs for the request
 * to each API call.
 *
 * $Id: Paypal.php 1978 2008-03-25 12:05:32GMT by atomless -
 *
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
*/
class Payment_Paypal_Driver implements Payment_Driver {

	// this array details the required fields within the arrays $set_express_checkout_fields,
	// $get_express_checkout_fields, $do_express_checkout_fields as well as the
	// fields wihtin api_connection and api_authorization
	private $required_fields = array
	(
		'USER'          => FALSE,
		'PWD'           => FALSE,
		'SIGNATURE'     => FALSE,

		'RETURNURL'     => FALSE,
		'CANCELURL'     => FALSE,

		'AMT'           => FALSE, // payment amount
	);


	//-- RESPONSE to setExpressCheckout calls will take the form:
	//-- https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token={20 single byte character timestamped token}
	//-- this token is passed back and forth throughout the stages of the express checkout process

	private $set_express_checkout_fields = array
	(
		//-- REQUIRED --//
		'METHOD'        => 'SetExpressCheckout',

		'RETURNURL'     => '',
		'CANCELURL'     => '',

		'AMT'           => '', // payment amount - MUST include decimal point followed by two further digits

		//-- OPTIONAL --//
		'CURRENCYCODE'  => '', // default is USD - only required if other currency needed
		'MAXAMT'        => '',

		// USERACTION defaults to 'continue'
		// if set to 'commit' the submit button on the paypal site transaction page is labelled 'Pay'
		// instead of 'continue' - meaning that you can just go ahead and call DoExpressCheckout
		// right away on the RETURNURL page on your site without needing a further order review page
		// with a 'pay now' button.
		'USERACTION'    => 'continue',

		'INVNUM'        => '', // Your own unique invoice / tracking number


		//-- set ADDROVERRIDE to '1' if you want to collect the shipping address on your site
		//-- and have that over-ride the user's stored details on paypal
		//-- if set to '1' you will of course also need to pass the shipping details!
		'ADDROVERRIDE'  => '0',

		'SHIPTONAME'         => '',
		'SHIPTOSTREET'       => '',
		'SHIPTOSTREET2'      => '',
		'SHIPTOCITY'         => '',
		'SHIPTOSTATE'        => '',
		'SHIPTOZIP'          => '',
		'SHIPTOCOUNTRYCODE'  => '', // list of country codes here: https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/countrycodes_new.html#1006794

		'LOCALECODE'    => 'US', // Defaults to 'US' - list of country codes here: https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/countrycodes_new.html#1006794

		//-- If YOU WANT TO APPLY CUSTOM STYLING TO PAYAPAL PAGES - see under SetExpressCheckout Request for descriptions here: https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/Appx_fieldreference.html#2557853
		'PAGESTYLE'     => '', //set this to match the name of any page style you set up in the profile subtab of your paypal account

		'HDRIMG'        => '', //header image displayed top left, size: 750px x 90px. defaults to business name in text

	// there are several other optional settings supported
	// see under SetExpressCheckout Request here : https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/Appx_fieldreference.html#2557853
	);

	private $get_express_checkout_fields = array
	(
		'METHOD' => 'GetExpressCheckoutDetails',
		'TOKEN'  => '' // this token is retrieved from the response to the SetExpressCheckout call
	);

	//-- associative array filled by the paypal api response to a call to the GetExpressCheckout method
	private $get_express_checkout_response = array();
	// responses contain these fields:
	// TOKEN
	// EMAIL
	// PAYERID     - paypal customer id -  13 single byte alpha numeric
	// PAYERSTATUS - verified or unverified
	// SALUTATION  - 20 single byte characters
	// FIRSTNAME   - 25 single byte characters
	// LASTNAME    - 25 single byte characters
	// MIDDLENAME  - 25 single byte characters
	// SUFFIX      - payer's suffix - 12 single byte character
	// COUNTRYCODE - list of country codes here: https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/countrycodes_new.html#1006794
	// BUSINESS    - payer's business name
	// SHIPTONAME
	// SHIPTOSTREET
	// SHIPTOSTREET2
	// SHIPTOCITY
	// SHIPTOSTATE
	// SHIPTOZIP
	// SHIPTOCOUNTRYCODE
	// ADDRESSSTATUS - status of the street address on file with paypal
	// CUSTOM        - freeform field as optionally set by you in the setExpressCheckout call
	// INVNUM        - invoice tracking number as optionally set by you in the setExpressCheckout call
	// PHONENUM      -  Note: PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one.
	// REDIRECTREQUIRED - flag to indicate whether you need to redirect the customer to back to PayPal after completing the transaction.

	private $do_express_checkout_fields = array
	(
		//-- REQUIRED --
		'METHOD'        => 'DoExpressCheckoutPayment',
		'TOKEN'         => '', // this token is retrieved from the response to the setExpressCheckout call
		'PAYERID'       => '',
		'AMT'           => '', // payment amount - MUST include decimal point followed by two further digits

		//-- OPTIONAL --
		'CURRENCYCODE'  => '', // default is USD - only required if other currency needed
		'INVNUM'        => '',
		'ITEMAMT'       => '', // sum cost of all items in order not including shipping or handling
		'SHIPPINGAMT'   => '',
		'HANDLINGAMT'   => '',
		'TAXAMT'        => '',

		//-- OPTIONAL ORDER CONTENTS INFO
		/* these fileds would obviously need setting dynamically but shown here as an example

		'L_NAME0'   => '', // max 127 single-byte characters product/item name
		'L_NUMBER0' => '', // max 127 single-byte characters product/item number
		'L_QTY0'    => '', // positive integer
		'L_TAXAMT0'  => '', // item sales tax amount
		'L_AMT0'     => '', // cost of item

		'L_NAME1'...

		'L_NAME2'...

		*/
	);

	private $api_authroization_fields = array
	(
		'USER'          => '',
		'PWD'           => '',
		'SIGNATURE'     => '',
		'VERSION'       => '3.2',
	);


	private $api_connection_fields = array
	(
		'ENDPOINT'      => 'https://api-3t.paypal.com/nvp',
		'PAYPALURL'     => 'https://www.paypal.com/webscr&cmd=_express-checkout&token=',
		'ERRORURL'      => '',
		'GETDETAILS'    => TRUE
	);

	private $array_of_arrays;

	private $test_mode = TRUE;

	private $nvp_response_array = array();
	// after successful transaction $nvp_response_array will contain
	// TOKEN           - The timestamped token value that was returned by SetExpressCheckout
	// TRANSACTIONID   - Unique transaction ID of the payment. 19 single-byte characters
	// TRANSACTIONTYPE - possible values: 'cart' or 'express-checkout'
	// PAYMENTTYPE     - Indicates whether the payment is instant or delayed. possible values: 'non', 'echeck', 'instant'
	// ORDERTIME       - Time/date stamp of payment
	// AMT             - The final amount charged, including any generic shipping and taxes set in your Merchant Profile.
	// CURRENCYCODE    - 3 char currency code:  https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/Appx_fieldreference.html#2557565
	// FEEAMT          - PayPal fee amount charged for the transaction
	// SETTLEAMT       - Amount deposited in your PayPal account after a currency conversion.
	// TAXAMT          - Tax charged on the transaction.
	// EXCHANGERATE    - Exchange rate if a currency conversion occurred.
	// PAYMENTSTATUS   - possible values: 'Completed' or 'Pending'
	// PENDINGREASON   - possible values: 'none', 'address', 'echeck', 'int1', 'multi-currency', 'verify', 'other'
	// REASONCODE      - The reason for a reversal if TransactionType is reversal. possible values: 'none', 'chargeback', 'guarantee', 'buyer-complaint', 'refund', 'other'
	// for more info see : https://www.paypal.com/en_US/ebook/PP_NVPAPI_DeveloperGuide/Appx_fieldreference.html#2557853

	/**
	* Sets the config for the class.
	*
	* @param  array  config passed from the library
	*/
	public function __construct($config)
	{
		$this->array_of_arrays = array
		(
			&$this->set_express_checkout_fields,
			&$this->get_express_checkout_fields,
			&$this->do_express_checkout_fields,
			&$this->api_authroization_fields,
			&$this->api_connection_fields
		);

		$this->set_fields($config);

		$this->test_mode = $config['test_mode'];

		if ($this->test_mode)
		{
			$this->api_authroization_fields['USER']      = $config['SANDBOX_USER'];
			$this->api_authroization_fields['PWD']       = $config['SANDBOX_PWD'];
			$this->api_authroization_fields['SIGNATURE'] = $config['SANDBOX_SIGNATURE'];

			$this->api_connection_fields['ENDPOINT']     = $config['SANDBOX_ENDPOINT'];
			$this->api_connection_fields['PAYPALURL']    = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
			$this->api_connection_fields['ENDPOINT']     = 'https://api-3t.sandbox.paypal.com/nvp';
		}

		$this->curl_config = $config['curl_config'];

		$this->session = Session::instance();

		Kohana::log('debug', 'PayPal Payment Driver Initialized');
	}

	/**
	*@desc set fields for nvp string
	*/
	public function set_fields($config)
	{

		foreach ($config as $key => $val)
		{
			// Handle any necessary field name translation
			switch ($key)
			{
				case 'amount':
					$key = 'AMT';
					break;
				default:
			}

			if (array_key_exists($key, $this->required_fields) AND !empty($val))
			{
				$this->required_fields[$key] = TRUE;
			}

			foreach ($this->array_of_arrays as &$arr)
			{
				if (array_key_exists($key, $arr))
				{
					$arr[$key] = $val;
				}
			}
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
				if ( ! $field)
				{
					$fields[] = $key;
				}
			}

			throw new Kohana_Exception('payment.required', implode(', ', $fields));
		}

		// stage 1 - if no token yet set then we know we just need to run set_express_checkout
		$paypal_token = $this->session->get('paypal_token', FALSE);
		if ( ! $paypal_token)
		{
			$this->set_express_checkout();
			return FALSE;
		}
		else
		{
			$this->set_fields(array('TOKEN' => $paypal_token));
		}

		// stage 2 (optional) retrieve the user info from paypal and store it in the get_express_checkout_response array
		// --------------------------------------------------------------------------------
		// *note: if you don't wish to record the user info (shipping address etc)
		//        then you can skip this stage by setting GETDETAILS to FALSE
		//        like so:
		//        $this->payment = new Payment('Paypal');
		//        $this->payment->GETDETAILS = FALSE;
		// IMPORTANT - if you do choose to skip this step you will need to extract
		//             the PayerID from the $_GET array in the method targeted by RETURNURL
		//             and use the value to set the PAYERID value of your payment object
		//             eg:
		//             $this->payment = new Payment('Paypal');
		//             $this->payment->PAYERID = $this->input->get('PayerID');
		// --------------------------------------------------------------------------------
		if ($this->api_connection_fields['GETDETAILS'])
		{
			$this->get_express_checkout();
		}

		// stage 3
		if (empty($this->do_express_checkout_fields['PAYERID']))
		{
			throw new Kohana_Exception('payment.required', 'PAYERID');
		}

		$this->do_express_checkout_payment();

		return (strtoupper($this->nvp_response_array['ACK']) == 'Success') ? TRUE : array_merge($this->nvp_response_array, $this->get_express_checkout_response);
	}

	/**
	* (stage 1)
	* Runs paypal authentication and sets up express checkout options (stage 1)
	*/
	protected function set_express_checkout()
	{
		$nvp_str = http_build_query($this->remove_empty_optional_fields($this->set_express_checkout_fields));

		$response = $this->make_paypal_api_request($nvp_str);

		parse_str(urldecode($response),$response_array);

		if (strtoupper($response_array['ACK']) == 'SUCCESS')
		{
			$paypal_token = $response_array['TOKEN'];

			// Redirect to paypal.com here
			$this->session->set('paypal_token', urldecode($paypal_token));

			// We are off to paypal to login!
			if ($this->set_express_checkout_fields['USERACTION']=='commit')
			{
				url::redirect($this->api_connection_fields['PAYPALURL'].$paypal_token.'&useraction=commit');
			}
			else
			{
				url::redirect($this->api_connection_fields['PAYPALURL'].$paypal_token);
			}
		}
		else // Something went terribly wrong...
		{
			throw new Kohana_User_Exception('SetExpressCheckout ERROR', Kohana::debug($response_array));

			Kohana::log('error', Kohana::debug('SetExpressCheckout response:'.$response_array));
			//url::redirect($this->api_connection_fields['ERRORURL']);
		}
	}

	/**
	* (stage 2)
	* Retrieves all the user info from paypal and stores it in the get_express_checkout_response array
	*
	*/
	protected function get_express_checkout()
	{
		$nvp_str = http_build_query($this->get_express_checkout_fields);

		$response = $this->make_paypal_api_request($nvp_str);

		parse_str(urldecode($response),$this->get_express_checkout_response);

		if (strtoupper($this->get_express_checkout_response['ACK']) == 'SUCCESS')
		{
			$this->set_fields(array('PAYERID' => $this->get_express_checkout_response['PAYERID']));
		}
		else // Something went terribly wrong...
		{
			throw new Kohana_User_Exception('GetExpressCheckout ERROR', Kohana::debug($this->get_express_checkout_response));

			Kohana::log('error', Kohana::debug('GetExpressCheckout response:'.$response));
			url::redirect($this->api_connection_fields['ERRORURL']);
		}
	}

	/**
	* (stage 3)
	* complete paypal transaction - store response in nvp_response_array
	*
	*/
	protected function do_express_checkout_payment()
	{
		$nvp_qstr = http_build_query($this->remove_empty_optional_fields($this->do_express_checkout_fields));

		$response = $this->make_paypal_api_request($nvp_qstr);

		parse_str(urldecode($response),$this->nvp_response_array);

		if (strtoupper($this->nvp_response_array['ACK']) != 'SUCCESS')
		{
			throw new Kohana_User_Exception('DoExpressCheckoutPayment ERROR', Kohana::debug($this->nvp_response_array));

			Kohana::log('error', Kohana::debug('GetExpressCheckout response:'.$response));
			url::redirect($this->api_connection_fields['ERRORURL']);
		}
	}

	/**
	* Runs the CURL methods to communicate with paypal.
	*
	* @param   string  paypal API method to run
	* @param   string  any additional name-value-pair query string data to send to paypal
	* @return  mixed
	*/
	protected function make_paypal_api_request($nvp_str)
	{
		$postdata = http_build_query($this->api_authroization_fields).'&'.$nvp_str;

		parse_str(urldecode($postdata),$nvpstr);

		Kohana::log('debug', 'Connecting to '.$this->api_connection_fields['ENDPOINT']);

		$ch = curl_init($this->api_connection_fields['ENDPOINT']);

		// Set custom curl options
		curl_setopt_array($ch, $this->curl_config);

		// Setting the nvpreq as POST FIELD to curl
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

		// Getting response from server
		$response = curl_exec($ch);

		if (curl_errno($ch))
		{
			throw new Kohana_User_Exception('CURL ERROR', Kohana::debug(array('curl_error_no' => curl_errno($ch), 'curl_error_msg' => curl_error($ch))));

			// Moving to error page to display curl errors
			$this->session->set_flash(array('curl_error_no' => curl_errno($ch), 'curl_error_msg' => curl_error($ch)));
			url::redirect($this->api_connection_fields['ERRORURL']);
		}
		else
		{
			curl_close($ch);
		}

		return $response;
	}

	/**
	* What is says on the tin
	* @param array
	* @return edited array
	*
	*/
	protected function remove_empty_optional_fields($arr)
	{
		foreach ($arr as $key => $val)
		{
			// don't include unset optional fields in the name-value pair request string
			if ($val==='') unset($arr[$key]);
		}
		return $arr;
	}

} // End Payment_Paypal_Driver Class
