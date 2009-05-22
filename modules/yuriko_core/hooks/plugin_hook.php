<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * This hook loads all the plugins that are enabled in the DB
 * and also runs any hook inside those plugins.
 */
class plugin_hook{

	public function __construct()
	{
		Event::add('system.ready', array($this, 'load'));
	}

	/**
	 * load all the plugins in the DB
	 */
	public function load()
	{
		$plugins = array();
		// Get the list of enabled plugins from the db
		$enabled_status = ORM::factory('plugin_status', 'enabled');
		foreach (ORM::factory('plugin')->where('plugin_status_id', $enabled_status->id)->find_all() as $plugin)
		{
			$plugins[] = DOCROOT.'plugins/'.$plugin->dir;
		}
		// Now set the modules
		Kohana::config_set('core.modules', array_merge(Kohana::config('core.modules'), $plugins));
		// We need to manually include the hook file for each module,
		// because the additional modules aren't loaded until after the application hooks are loaded.
		foreach ($plugins as $plugin)
		{
			if(is_dir($plugin.'/hooks'))
			{
				$d = dir($plugin.'/hooks'); // Load all the hooks
				while (($entry = $d->read()) !== FALSE)
					if ($entry != '.' AND $entry != '..')
						include $plugin.'/hooks/'.$entry;
			}
		}
	}
}
new plugin_hook;