<?php
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
		if ((!$plugin->loaded) OR ($plugin->enabled)) Event::run('system.404');

		if(isset($_POST['confirm']))
		{
			if (TRUE === $status = $plugin->enable())
			{
				notice::add('Plugin Enabled', 'success');
			}
			else
			{
				foreach($status->errors('plugin_errors') as $error)
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
		$this->template->content = View::factory('admin/plugins/enable');
		$this->template->content->plugin = $plugin;
	}
	public function disable($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded) OR (!$plugin->enabled)) Event::run('system.404');

		if(isset($_POST['confirm']))
		{
			if (TRUE === $status = $plugin->disable())
			{
				notice::add('Plugin Disabled', 'success');
			}
			else
			{
				foreach($status->errors('plugin_errors') as $error)
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

} // End Admin Plugins Controller