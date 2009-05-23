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
		// Taken from Argentum Invoice http://argentuminvoice.com - THANKS ZOMBOR!
		$tables = View::factory('admin/installer/content/basic/schema')->render();
		$db = Database::instance();
		$query = '';
		foreach (explode("\n", $tables) as $sql)
		{
			if (trim($sql) != "" AND strpos($sql, "--") === FALSE)
			{
				$query .= $sql;
				if (preg_match("/;[\040]*\$/", $sql))
				{
					$db->query($query);
					$query = '';
				}
			}
		}
		notice::add('DB Table for Basic Content Plugin Created', 'success');
		Session::instance()->set('yuriko.plugin_setup', TRUE);
		url::redirect(Router::$current_uri);
	}
	public function uninstall()
	{
		if (isset($_POST['confirm']))
		{
			//uninstall plugin
			// Taken from Argentum Invoice http://argentuminvoice.com - THANKS ZOMBOR!
			$tables = View::factory('admin/installer/content/basic/uninstall')->render();
			$db = Database::instance();
			$query = '';
			foreach (explode("\n", $tables) as $sql)
			{
				if (trim($sql) != "" AND strpos($sql, "--") === FALSE)
				{
					$query .= $sql;
					if (preg_match("/;[\040]*\$/", $sql))
					{
						$db->query($query);
						$query = '';
					}
				}
			}
			notice::add('DB Table for Basic Content Plugin Dropped', 'success');
			//set session var to tell main setup that plugin is done uninstalling
			Session::instance()->set('yuriko.plugin_setup', TRUE);
			//redirect to current url to finish uninstallation
			url::redirect(Router::$current_uri);
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			//no need to finish uninstallation
			url::redirect('admin/plugins/manage');
		}
		else
		{
			echo View::factory('forms/simple_confirmation')
				->set('message', 'This will delete the Basic_Content table and all its contents.');
		}
	}
}