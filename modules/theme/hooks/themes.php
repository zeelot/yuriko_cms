<?php

class themes_hook {

  public function __construct()
  {
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'load_themes'));
	//Event::add('system.pre_controller', array($this, 'add_form_module'));
    $this->session = Session::instance();
  }

  public function load_themes()
  {
      /*
	   * @TODO: fix the user profile
	   if(Auth::instance()->logged_in())
	  {
		  $user_theme = $this->session->get('auth_user')->profile->theme;
		  if($user_theme->id > 0)
		  {
			  Kohana::config_set
			  ( 'themes.active', array
				  (
					  'name'    => $user_theme->name,
					  'dir'     => $user_theme->dir,
				  )
			  );
			  Kohana::config_set('core.modules', array_merge(Kohana::config('core.modules'), array(DOCROOT.'themes/'.$user_theme->dir)));
		  }
	  }
	   */

	  // the default theme should be loaded for fallback
	  Kohana::config_set('core.modules', array_merge(Kohana::config('core.modules'), array(DOCROOT.'themes/default')));
  }

  public function add_form_module()
  {
	$user = $this->session->get('auth_user');
	$view = View::factory('form_modules/user_profile/theme_selection')
			->set('themes', ORM::factory('theme')->find_all())
			->set('user', $user);
	//add the themes dropdown to the user_profile form (found in the profile page)
	form_module::set('user_profile', $view);
  }
}
new themes_hook;

