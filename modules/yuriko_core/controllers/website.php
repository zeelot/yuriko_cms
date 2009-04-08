<?php
abstract class Website_Controller extends Template_Controller{

	// Template view name
	public $template = 'templates/static/default';

	public function __construct()
	{
		Controller::__construct();//no longer want template::construct

		// Load the template (if it's set)
		if($this->template)
		{
			$this->template = new View($this->template);
		}
		if (request::is_ajax())
		{
			$this->template = new View('templates/static/ajax');
		}
		if ($this->auto_render == TRUE)
		{
			// Render the template immediately after the controller method
			Event::add('system.post_controller', array($this, '_render'));
		}

		$this->template->theme = Kohana::config('themes.active', FALSE, FALSE);

		
	}
} // End Website_Controller