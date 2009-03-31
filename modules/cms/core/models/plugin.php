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
