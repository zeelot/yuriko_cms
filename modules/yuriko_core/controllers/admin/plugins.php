<?php defined('SYSPATH') OR die('No direct access allowed.');
/* 
 * Controller to load/unload cms plugins
 */

class Plugins_Controller extends Admin_Controller {

	/**
	 * List all the basic content nodes for editing
	 */
	public function manage()
	{
		ORM::factory('plugin')->sync();
		$plugins = ORM::factory('plugin')->find_all();
		$this->template->content = View::factory('admin/plugins/manage');
		$this->template->content->plugins = $plugins;
	}

	public function info($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if (!$plugin->loaded) event::run('system.404');
		$this->template->content = View::factory('admin/plugins/info');
		$this->template->content->plugin = $plugin;
	}

	public function enable($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded) OR ($plugin->plugin_status->name == 'enabled'))
			Event::run('system.404');
		//if the plugin has an install script, run it.
		//stop running when $_SESSION['yuriko.plugin_setup'] is TRUE
		if (
			$plugin->plugin_status->name == 'uninstalled'
			AND $plugin->installer == 1
			AND (bool)!Session::instance()->get('yuriko.plugin_setup')
			)
		{
			//temporarily load the module to get to the installer files
			Kohana::config_set('core.modules',
				array_merge(Kohana::config('core.modules'),
				 array(DOCROOT.'plugins/'.$plugin->dir)));
			//run installation
			$installation = Component::factory('admin/installer/'.$plugin->dir)
				->method('install', array($plugin));
			$this->template->content = $installation;
		}
		else
		{
			if (isset($_POST['confirm']))
			{
				//enable the plugin and remove the session item
				$array = $plugin->as_array();
				$array['action'] = 'enable';
				$array['plugin_status_id'] = ORM::factory('plugin_status', 'enabled')->id;
				if ($plugin->validate($array))
				{
					$plugin->save();
					notice::add('Plugin Enabled', 'success');
				}
				else
				{
					foreach($array->errors('plugin_errors') as $error)
					{
						notice::add($error, 'error');
					}
				}
				Session::instance()->delete('yuriko.plugin_setup');
				url::redirect('admin/plugins/manage');
			}
			elseif(isset($_POST['cancel']))
			{
				Session::instance()->delete('yuriko.plugin_setup');
				notice::add('Action Cancelled!', 'success');
				url::redirect('admin/plugins/manage');
			}
			$this->template->content = View::factory('admin/plugins/enable');
			$this->template->content->plugin = $plugin;
		}
	}
	public function disable($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded) OR (!$plugin->plugin_status->name == 'enabled'))
			Event::run('system.404');
		//we aren't uninstalling the plugin, just disable it so it doesn't load
		if (isset($_POST['confirm']))
		{
			//disable the plugin
			$array = $plugin->as_array();
			$array['action'] = 'disable';
			$array['plugin_status_id'] = ORM::factory('plugin_status', 'disabled')->id;
			if ($plugin->validate($array))
			{
				$plugin->save();
				notice::add('Plugin Disabled', 'success');
			}
			else
			{
				foreach($array->errors('plugin_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
			url::redirect('admin/plugins/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/plugins/manage');
		}
		$this->template->content = View::factory('admin/plugins/disable');
		$this->template->content->plugin = $plugin;
	}
	public function install($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded)) Event::run('system.404');
		if (
			$plugin->installer == 1
			AND (bool)!Session::instance()->get('yuriko.plugin_setup')
			)
		{
			//temporarily load the module to get to the installer files
			Kohana::config_set('core.modules',
				array_merge(Kohana::config('core.modules'),
				 array(DOCROOT.'plugins/'.$plugin->dir)));
			//run installation
			$installation = Component::factory('admin/installer/'.$plugin->dir)
				->method('install', array($plugin));
			$this->template->content = $installation;
		}
		else
		{
			//installation complete, redirect
			notice::add('Plugin Installed', 'success');
			url::redirect('admin/plugins/manage');
		}
	}
	public function uninstall($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded)
			OR ($plugin->plugin_status->name == 'uninstalled')
			OR ($plugin->installer == 0)
			)
			Event::run('system.404');
		if ((bool)!Session::instance()->get('yuriko.plugin_setup'))
		{
			//run uninstallation
			$installation = Component::factory('admin/installer/'.$plugin->dir)
				->method('uninstall', array($plugin));
			$this->template->content = $installation;
		}
		else
		{
			//change plugin status
			$array = $plugin->as_array();
			$array['action'] = 'uninstall';
			$array['plugin_status_id'] = ORM::factory('plugin_status', 'uninstalled')->id;
			if ($plugin->validate($array))
			{
				$plugin->save();
				notice::add('Plugin Uninstalled', 'success');
			}
			else
			{
				foreach($array->errors('plugin_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
			url::redirect('admin/plugins/manage');
		}
	}

} // End Admin Plugins Controller