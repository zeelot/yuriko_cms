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
		//enable the plugin to access the config
		if(!$plugin->enabled)
		{
			kohana::config_set('core.modules', 
				array_merge(kohana::config('core.modules'),
					array(MODPATH.'cms/plugins/'.$plugin->dir)));
		}
		$plugin = kohana::config('plugin.'.$plugin->dir);
		$this->template->content = View::factory('admin/plugins/info');
		$this->template->content->plugin = $plugin;
	}

	public function enable($id = NULL)
	{
		/**
		 * @TODO: fix dependency checking possibly put it into a helper
		 */
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded) OR ($plugin->enabled)) Event::run('system.404');
		//need to enable it temporarily to use the config
		Kohana::config_set('core.modules', array_merge(Kohana::config('core.modules'), array(MODPATH.'cms/plugins/'.$plugin->dir)));
		$config = kohana::config('plugin.'.$plugin->dir);
		//check dependencies
		$dep_pass = TRUE;
		foreach ($config['dependencies'] as $dependency => $version)
		{
			//if dependency = core, check cms version
			if($dependency == 'core')
			{
				if(version_compare($version, kohana::config('cms.version'), '>'))
				{
					$dep_pass = FALSE;
					notice::add('This plugin is not compatible with the current CMS version', 'error');
				}
			}
			else
			{
				$dep = kohana::config('plugin.'.$dependency, FALSE, FALSE);
				if((!$dep) OR (version_compare($version, $dep['version'], '>')))
				{
					$dep_pass = FALSE;
					notice::add('This plugin requires '.$dependency.' version '.$version.' or higher.', 'error');
				}
			}
		}
		if($dep_pass)
		{
			$plugin->enabled = 1;
			$plugin->save();
			notice::add('Plugin Enabled', 'success');
		}
		url::redirect('admin/plugins/manage');
	}
	public function disable($id = NULL)
	{
		$plugin = ORM::factory('plugin', $id);
		if ((!$plugin->loaded) OR (!$plugin->enabled)) Event::run('system.404');

		if(isset($_POST['confirm']))
		{
			$plugin->enabled = 0;
			$plugin->save();
			notice::add('Plugin Disabled', 'success');
			url::redirect('admin/plugins/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/plugins/manage');
		}
		$this->template->content = View::factory('admin/plugins/delete');
	}

} // End Admin Plugins Controller