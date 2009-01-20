<?php

class themes_hook {

  public function __construct()
  {
    // Hook into routing
    Event::add('system.pre_controller', array($this, 'load_themes'));
    $this->session = Session::instance();
  }

  public function load_themes()
  {
      if(Auth::instance()->logged_in())
	  {
		  $user_theme = Session::instance()->get('auth_user')->profile->theme;
		  if($user_theme->id > 0)
		  {
			  Kohana::config_set
			  ( 'themes.active', array
				  (
					  'name'    => $user_theme->name,
					  'dir'     => $user_theme->dir,
				  )
			  );
		  }
	  }
  }
}
new themes_hook;

