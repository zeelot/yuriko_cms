<?php

abstract class Website_Controller extends Template_Controller {

	// Template view name
	public $template = 'template/default';

	// Default to do auto-rendering
	public $auto_render = TRUE;

	public function __construct()
	{
	  parent::__construct();
	  $this->template->theme = Kohana::config('themes.active');
	  //css and js that will load on all themes
	  assets::add_script('jquery-1.3.min', 'global');
	  assets::add_stylesheet('reset', 'global');
	  assets::add_stylesheet('styles', 'global');
	  
	  //css that will load on any theme that wants to use this framework
	  assets::add_stylesheet('960', '960_framework');
	  //basic typography
	  assets::add_stylesheet('typography', 'global_typography');
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