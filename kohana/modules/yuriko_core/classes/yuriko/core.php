<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Yuriko_Core {

	public static function anchor($page, $title = NULL, array $attributes = NULL, array $query = NULL, $retain_get = FALSE, $protocol = NULL) {

		if ($retain_get)
		{
			// merge with the current $_GET
			$query = array_merge((array)$query, $_GET);
		}
		
		//create query string
		$query = http_build_query((array)$query);

		return html::anchor(Route::get('page')
			->uri(array('uri' => $page)).'?'.$query, $title, $attributes, $protocol);
	}

}