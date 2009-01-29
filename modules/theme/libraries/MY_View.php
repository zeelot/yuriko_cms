<?php

class View extends View_Core{

	public static function factory($name = NULL, $data = NULL, $type = NULL, $theme = NULL)
	{
		return new View($name, $data, $type, $theme);
	}
	
	public function __construct($name = NULL, $data = NULL, $type = NULL, $theme = NULL)
	{
		if (is_string($name) AND $name !== '')
		{
			// Set the filename
			$this->set_filename($name, $type, $theme);
		}

		if (is_array($data) AND ! empty($data))
		{
			// Preload data using array_merge, to allow user extensions
			$this->kohana_local_data = array_merge($this->kohana_local_data, $data);
		}
	}
	
	public function set_filename($name, $type = NULL, $theme = NULL)
	{
		//if the themes view exists, prepend the theme path to $name
		//if not, check default theme, prepend that to $name if it exists
		//if not, fall back to unthemed
		if($theme === NULL)
		{
			if(Kohana::find_file('views', Kohana::config('themes.active.dir').'/html/'.$name))
			{
				$name = Kohana::config('themes.active.dir').'/html/'.$name;
			}
			elseif(Kohana::find_file('views', Kohana::config('themes.default.dir').'/html/'.$name))
			{
				$name = Kohana::config('themes.default.dir').'/html/'.$name;
			}
		}
		else
		{
			$name = $theme.'/'.$name;
		}
		return parent::set_filename($name, $type);
	}
}
