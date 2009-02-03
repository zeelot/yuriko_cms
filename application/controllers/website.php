<?php

abstract class Website_Controller extends Template_Controller {

	// Template view name
	public $template = 'template/default';

	// Default to do auto-rendering
	public $auto_render = TRUE;

	public function __construct()
	{
	  parent::__construct();
	  $this->template->theme = Kohana::config('themes.active', FALSE, FALSE);
	  //css and js that will load on all themes
	  assets::add_script('jquery-1.3.min', 'global');
	  assets::add_stylesheet('reset', 'global');
	  assets::add_stylesheet('styles', 'global');
	  //profiler and other kohana related css
	  assets::add_stylesheet('kohana', 'global');
	  
	  //css that will load on any theme that wants to use this framework
	  assets::add_stylesheet('960', '960_framework');
	  //basic typography
	  assets::add_stylesheet('typography', 'global_typography');

	  //login widget for pages to use
	  widget::set('user_info', Component::factory('widget_user')->method('info'));
	  $this->profiler = new Profiler;
	}

	/**
	 * Render the loaded template.
	 */
	public function _render()
	{
		if ($this->auto_render == TRUE)
		{
			// Render the template when the class is destroyed
			$this->template->render(TRUE);
		}
	}
} // End Website_Controller