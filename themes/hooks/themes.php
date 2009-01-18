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
      $themes = Kohana::config('themes.available');
      Kohana::config_set
      (
          'themes.active',
          $themes[$this->session->get( 'theme', Kohana::config('themes.active.name'))]
      );
  }
}
new themes_hook;
