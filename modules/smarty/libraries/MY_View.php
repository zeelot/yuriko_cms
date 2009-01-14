<?php defined('SYSPATH') OR die('No direct access allowed.');

class View extends View_Core {

	public function __construct($name, $data = NULL, $type = NULL)
	{
		$type = NULL;

		if (Kohana::config('smarty.integration') == TRUE AND Kohana::find_file('views', $name, FALSE, $type))
		{
			$type = empty($type) ? Kohana::config('smarty.templates_ext') : $type;
		}

		parent::__construct($name, $data, $type);
	}
}
