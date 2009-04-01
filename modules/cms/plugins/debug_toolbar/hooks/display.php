<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Disable auto render when IN_PRODUCTION is true
 */
if (!IN_PRODUCTION) 
{
	/*
	 * Allows the debug toolbar to inject itsself 
	 * into the html
	 */
	Event::add('system.display', array('DebugToolbar', 'render'));
}