<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Admin_Installer_Content_Basic_Controller extends Controller {

	public function index()
	{
		
	}

	public function install(Plugin_Model $plugin)
	{
		echo 'DO INSTALL! '.$plugin->name;
		Session::instance()->set('yuriko.plugin_installed', TRUE);
	}
	public function uninstall()
	{
		echo 'DO UNINSTALL!';
	}
}