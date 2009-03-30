<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Payment driver interface
 *
 * $Id: Payment.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Payment
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
interface Payment_Driver {

	/**
	 * Sets driver fields and marks reqired fields as TRUE.
	 *
	 * @param  array  array of key => value pairs to set
	 */
	public function set_fields($fields);

	/**
	 * Runs the transaction.
	 *
	 * @return  boolean
	 */
	public function process();

} // End Payment Driver Interface