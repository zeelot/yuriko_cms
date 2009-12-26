<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Extends the Kohana_View class to add tracking of loaded views.
 * This can be useful for figuring out what assets to include based
 * on the specific views that were used for a request.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

 class Yuriko_View extends Kohana_View {

	 public static $loaded = array();

	 /**
	 * Sets the initial view filename and local data.
	 *
	 * @param   string  view filename
	 * @param   array   array of values
	 * @return  void
	 */
	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		//add this view to $loaded (only once)
		self::$loaded[$file] = $file;
	}
 }