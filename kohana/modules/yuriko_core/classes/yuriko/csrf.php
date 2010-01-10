<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Helps validate CSRF Tokens on forms for added security.
 * Taken from the Kohana Forums - Thanks!
 */

class Yuriko_Csrf {

	public static function token()
	{
		if (($token = Session::instance()->get('csrf')) === FALSE)
			Session::instance()->set('csrf', ($token = text::random('alnum', 16)));
		return $token;
	}

	public static function valid($token)
	{
		return ($token === arr::remove('csrf', $_SESSION));
	}
}