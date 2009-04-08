<?php

class Plugin_Model extends ORM {

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'dir';
		}

		return parent::unique_key($id);
	}

	public function __set($key, $value)
	{
		if ($key === 'dependencies')
		{
			$value = serialize($value);
		}

		parent::__set($key, $value);
	}
	public function __get($key)
	{
		if ($key === 'dependencies')
		{
			return unserialize(parent::__get($key));
		}
		else
		{
			return parent::__get($key);
		}
	}

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim', 'name', 'dir', 'description', 'version')
			->add_rules('name', 'required', 'length[1,127]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('dir', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('dependencies', 'is_array')
			->add_rules('description', 'required', 'length[1,1000]')
			->add_rules('notice_enable', 'length[1,1000]')
			->add_rules('notice_disable', 'length[1,1000]')
			->add_rules('version', 'required', 'length[1,15]');
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
		foreach ($array['dependencies'] as $dependency => $version)
		{
			//if dependency = core, check cms version
			if($dependency == 'core')
			{
				if(version_compare($version[0], kohana::config('cms.version'), '>'))
				{
					//core is too old
					$array->add_error($field, 'core_upgrade', array($version[0]));
				}
				elseif(isset($version[1]) AND version_compare($version[1], kohana::config('cms.version'), '<'))
				{
					//core is too new
					$array->add_error($field, 'core_downgrade', array($version[1]));
				}
			}
			else
			{
				$dep = ORM::factory('plugin', $dependency);
				if(!$dep->loaded)
				{
					//the plugin is not installed
					$array->add_error($field, 'dependency_install', array($dependency, $version[0]));
				}
				else
				{
					if(!$dep->enabled)
					{
						//the plugin needs to be loaded
						$array->add_error($field, 'dependency_enable', array($dep->name, $version[0]));
					}
					if(version_compare($version[0], $dep->version, '>'))
					{
						//the required plugin is too old
						$array->add_error($field, 'dependency_upgrade', array($dep->name, $version[0]));
					}
					elseif(isset($version[1]) AND version_compare($version[1], $dep->version, '<'))
					{
						//the required plugin is too new
						$array->add_error($field, 'dependency_downgrade', array($dep->name, $version[1]));
					}
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
			if(array_key_exists($this->dir, $plugin->dependencies))
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
		foreach(filesystem::get_folders(DOCROOT.'plugins/') as $plugin)
		{
			$plugins[] = DOCROOT.'plugins/'.$plugin;
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
				if(in_array(DOCROOT.'plugins/'.$plugin['dir'], $loaded))
				{
					$new->enabled = 1;
				}
				$new->save();
			}
			else
			{
				foreach ($plugin->errors('plugin_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		//restore the original modules
		Kohana::config_set('core.modules', $loaded);
	}
}
