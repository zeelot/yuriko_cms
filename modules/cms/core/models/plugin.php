<?php

class Plugin_Model extends ORM {

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[1,127]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('dir', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('description', 'required', 'length[1,500]')
			->add_rules('version', 'required', 'length[1,5]');
		return parent::validate($array, $save);
	}

	public function is_enabled()
	{
		return (bool)$this->enabled;
	}
	public function is_disabled()
	{
		return !$this->is_enabled();
	}
	public function enable_callback(Validation $array, $field)
	{
		//enable the plugin to check the config
		Kohana::config_set('core.modules',
			array_merge(Kohana::config('core.modules'),
				array(MODPATH.'cms/plugins/'.$array->dir)));
		$config = kohana::config('plugin.'.$array->dir);
		foreach ($config['dependencies'] as $dependency => $version)
		{
			//if dependency = core, check cms version
			if($dependency == 'core')
			{
				if(version_compare($version, kohana::config('cms.version'), '>'))
				{
					$array->add_error($field, 'core_dependency', array($version));
				}
			}
			else
			{
				$dep = kohana::config('plugin.'.$dependency, FALSE, FALSE);
				if((!$dep) OR (version_compare($version, $dep['version'], '>')))
				{
					$array->add_error($field, 'dependency', array($dependency, $version));
				}
			}
		}
	}
	/**
	 * This callback needs to go through all the enabled plugins
	 * and check if any of them depend on this plugin.
	 */
	public function disable_callback(Validation $array, $field)
	{
		$plugins = ORM::factory('plugin')->where('enabled', 1)->find_all();
		//check each plugins dependencies
		foreach($plugins as $plugin)
		{
			if(array_key_exists($this->dir, kohana::config('plugin.'.$plugin->dir.'.dependencies')))
			{
				//plugin depends on this one
				$array->add_error($field, 'needed', array($plugin->name));
			}
		}
	}
	public function enable()
	{
		$array = $this->as_array();

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('enabled', array($this, 'is_disabled'))
			->add_callbacks('enabled', array($this, 'enable_callback'));
		//return the validation object on failure
		if($array->validate())
		{
			$this->enabled = 1;
			$this->save();
			return TRUE;
		}
		else
		{
			return $array;
		}
	}
	public function disable()
	{
		$array = $this->as_array();

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('enabled', array($this, 'is_enabled'))
			->add_callbacks('enabled', array($this, 'disable_callback'));
		//return the validation object on failure
		if($array->validate())
		{
			$this->enabled = 0;
			$this->save();
			return TRUE;
		}
		else
		{
			return $array;
		}
	}
	/**
	 * Syncs the database table with the plugins directory.
	 * This should only be done in the admin panel to make sure
	 * all the correct plugins are listed.
	 */
	public function sync()
	{
		//delete everything in the db first (truncate resets id too)
		Database::instance()->query('TRUNCATE TABLE plugins');
		//original modules so we can restore this
		$loaded = Kohana::config('core.modules');
		//we need to get to the config files for all the plugins so they must
		//all be loaded first
		$plugins = array();
		foreach(filesystem::get_folders(MODPATH.'cms/plugins/') as $plugin)
		{
			$plugins[] = MODPATH.'cms/plugins/'.$plugin;
		}
		//load the plugin so we can get the information
		Kohana::config_set('core.modules', array_merge(Kohana::config('core.modules'), $plugins));
		
		foreach(Kohana::config('plugin') as $key => $plugin)
		{
			//add each plugin to the DB
			$new = ORM::factory('plugin');
			if($new->validate($plugin))
			{
				//if the plugin is in the $loaded array, set enabled to true
				if(in_array(MODPATH.'cms/plugins/'.$plugin['dir'], $loaded))
				{
					$new->enabled = 1;
				}
				$new->save();
			}
			else
			{
				foreach ($plugin->errors() as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		//restore the original modules
		Kohana::config_set('core.modules', $loaded);
	}
}
