<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2010 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */
 
class Controller_Yuriko_Admin_Main extends Controller_Yuriko_Admin {

	public function action_index()
	{
		$this->template->content = 'hello world!';
		$this->title = 'admin';

		$this->request->response = $this->template;
	}

} // End Controller_Yuriko_Admin_Main