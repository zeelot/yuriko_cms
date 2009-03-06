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
	  //profiler and other kohana related css
	  

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