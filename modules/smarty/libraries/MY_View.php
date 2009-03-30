<?php defined('SYSPATH') OR die('No direct access allowed.');

class View extends View_Core {

	public function __construct($name, $data = NULL, $type = NULL)
	{
		$smarty_ext = Kohana::config('smarty.templates_ext');

		if (Kohana::config('smarty.integration') == TRUE AND Kohana::find_file('views', $name, FALSE, (empty($type) ? $smarty_ext : $type)))
		{
			$type = empty($type) ? $smarty_ext : $type;
		}

		parent::__construct($name, $data, $type);
	}
}
