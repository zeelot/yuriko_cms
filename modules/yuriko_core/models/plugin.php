<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Plugin_Model extends ORM {

	protected $has_one = array('plugin_status');
	protected $ignored_columns = array('arguments');

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
		return parent::__get($key);
	}

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->add_rules('name', 'required', 'length[1,127]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('dir', 'required', 'length[1,127]', 'chars[a-zA-Z0-9_./]')
			->add_rules('version', 'required', 'length[1,15]')
			->add_rules('description', 'required', 'length[1,1000]')
			->add_rules('dependencies', 'is_array')
			->add_rules('arguments', 'is_array')
			->add_rules('notice_enable', 'length[1,1000]')
			->add_rules('notice_disable', 'length[1,1000]')
			->add_rules('installer', 'chars[01]')
			->add_rules('plugin_status_id', 'chars[1-3]');
		switch ($array['action']) {
			case 'sync':

				break;
			case 'install':
				break;
			case 'uninstall':
				break;
			case 'enable':
				$array->add_callbacks('plugin_status_id', array($this, 'enable_callback'));
				break;
			case 'disable':
				$array->add_callbacks('plugin_status_id', array($this, 'disable_callback'));
				break;
			default:
				break;
		}
		return parent::validate($array, $save);
	}
	public function is_enabled()
	{
		return ((bool)$this->plugin_status->name == 'enabled');
	}
	public function is_disabled()
	{
		return ((bool)$this->plugin_status->name == 'disabled');
	}
	public function is_uninstalled()
	{
		return ((bool)$this->plugin_status->name == 'uninstalled');
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
					//the plugin does not exist in the plugins folder
					$array->add_error($field, 'dependency_install', array($dependency, $version[0]));
				}
				else
				{
					if($dep->plugin_status->name != 'enabled')
					{
						//the plugin needs to be enabled
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
		$plugins = ORM::factory('plugin')
			->where('plugin_status_id', ORM::factory('plugin_status', 'enabled')->id)
			->find_all();
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
	/**
	 * Syncs the database table with the plugins directory.
	 * This should only be done in the admin panel to make sure
	 * all the correct plugins are listed.
	 */
	public function sync()
	{
		//store all the statuses of the current plugin
		$plugin_statuses = array();
		$plugins = ORM::factory('plugin')->find_all();
		foreach ($plugins as $plugin)
		{
			$plugin_statuses[$plugin->dir] = $plugin->plugin_status_id;
		}
		//delete everything in the db (truncate resets id too)
		Database::instance()->query('TRUNCATE TABLE plugins');
		//original modules so we can restore this easily
		$loaded = Kohana::config('core.modules');
		$plugins = filesystem::get_folders(DOCROOT.'plugins/');
		$ps = array();
		//this is getting really hacky
		foreach ($plugins as $p)
		{
			$ps[] = DOCROOT.'plugins/'.$p;
		}
		//load the plugin so we can get the information
		Kohana::config_set('core.modules',
			array_merge(Kohana::config('core.modules'), $ps));
		foreach($plugins as $plugin)
		{
			$config = Kohana::config('plugin.'.$plugin);
			
			//add status to the config
			if (isset($plugin_statuses[$plugin]))
			{
				$config['plugin_status_id'] = $plugin_statuses[$plugin];
			}
			else
			{
				//set to uninstalled
				$config['plugin_status_id'] = ORM::factory('plugin_status', 'uninstalled')->id;
			}
			//if installer is not set and id = uninstalled, set it to disabled
			if ((!isset($config['installer']) OR (bool)$config['installer'] == 0)
				AND	($config['plugin_status_id'] == ORM::factory('plugin_status', 'uninstalled')->id))
			{
				$config['plugin_status_id'] = ORM::factory('plugin_status', 'disabled')->id;
			}

			//the array key is the dir
			$config['dir'] = $plugin;
			//this lets validation know what rules to add
			$config['action'] = 'sync';
			//add each plugin to the DB
			$new = ORM::factory('plugin');
			if($new->validate($config))
			{
				$new->save();
			}
			else
			{
				foreach ($config->errors('plugin_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		//restore the original modules
		Kohana::config_set('core.modules', $loaded);
	}
}
