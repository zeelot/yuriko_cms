<?php

class Documentation_Controller extends Website_Controller{

	/**
	 * loads the faq page of the specified module
	 *
	 * @param <string> $module
	 */
	public function load($module = FALSE)
	{
		if(!$module)
		{
			$this->template->content = View::factory('content/documentation/home');
		}
		else
		{
			$this->template->content = View::factory('content/documentation/'.$module);
		}
	}
}