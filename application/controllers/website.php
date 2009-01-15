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