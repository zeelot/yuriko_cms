<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

 abstract class Controller_Yuriko_Template extends Controller_Template {

	/**
	 * @var  string  page template
	 */
	public $template = 'templates/default';

	/**
	 * @var  string  page title
	 */
	public $title = 'YurikoCMS';

	/**
	 * Assigns the title to the template.
	 *
	 * @param   string   request method
	 * @return  void
	 */
	public function after()
	{
		$this->template->title = $this->title;
		parent::after();
	}

} // End Controller_Yuriko_Template