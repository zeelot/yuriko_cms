<?php

class View extends View_Core{
	
	//hold an array of loaded views (this helps me decide which assets to load)
	public static $loaded = array();
	public function __construct($name = NULL, $data = NULL, $type = NULL)
	{
		//the $name as key is for duplicate views
		self::$loaded[$name] = $name;
		parent::__construct($name, $data, $type);
	}
}