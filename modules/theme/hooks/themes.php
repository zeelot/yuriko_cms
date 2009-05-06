<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * This is the hook responsible for enabling themes throughout the site
 */
class themes_hook {

	public function __construct()
	{
		// Hook into routing
		Event::add('system.ready', array($this, 'load_themes'));
		Event::add('system.pre_controller', array($this, 'add_form_module'));
	}

	public function load_themes()
	{
		$theme = ORM::factory('site_setting', 'site_theme')->value;
		Kohana::config_set('core.modules', array_merge(array(DOCROOT.'themes/default'), Kohana::config('core.modules')));
		if($theme!='default')
		{
			Kohana::config_set('core.modules', array_merge(array(DOCROOT.'themes/'.$theme), Kohana::config('core.modules')));
		}
	}

	public function add_form_module()
	{
		$themes = filesystem::get_folders(DOCROOT.'themes/');
		$sel = ORM::factory('site_setting', 'site_theme')->value;
		$view = View::factory('form_modules/site_settings/theme_selection')
			->set('themes', $themes)
			->set('sel', $sel);
		//add the themes dropdown to the site_settings form
		form_module::set('site_settings', $view);
  }
}
new themes_hook;

