<?php
/*
 * No longer extends Template_Controller because I needed to edit a few things
 * $template = FALSE; now does not throw an error but you will
 * have to specify a template view before assigning vars.
 * mainly for db content
 * 
 */
abstract class Website_Controller extends Controller{

	// Template view name
	public $template = 'template/default';

	// Default to do auto-rendering
	public $auto_render = TRUE;

	public function __construct()
	{
		parent::__construct();

		// Load the template (if it's set)
		if($this->template)
		{
			$this->template = new View($this->template);
		}

		if ($this->auto_render == TRUE)
		{
			// Render the template immediately after the controller method
			Event::add('system.post_controller', array($this, '_render'));
		}

		$this->template->theme = Kohana::config('themes.active', FALSE, FALSE);

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