<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
* Fragment Cache Helper Class.  This class allows you to cache specific
* sections of your View file.
*
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class frache_Core {

	//this is the stack of names (for nested fragment support)
	public static $stack = array();
	//the event to parse the html for fragments needs to run only once
	//and only if a fragment needs to be cached
	public static $added_event = FALSE;

	public static $fragments = array();

	/**
	 * Begins recording a new fragment if it isn't already cached.
	 *
	 * @param <string> fragment name
	 * @param <int> cache duration
	 * @return <bool> wether the fragment is in Cache
	 */
	public static function start($name = 'default', $duration = NULL)
	{
		$cache = Cache::instance();
		$old = $cache->get($name);
		if($old)
		{
			//load cached fragment
			echo $old;
			return FALSE;
		}
		else
		{
			//start 'recording' the fragment
			echo '<!-- begin frache '.$name.' -->';
			//add to stack for stop() method to pop (nested support)
			self::$stack[] = array
			(
				'name' => $name,
				'duration' => $duration,
			);
			if(!self::$added_event)
			{
				Event::add('system.display', array('frache', 'store'));
				self::$added_event = TRUE;
			}
			return TRUE;
		}
	}

	/**
	 * Stops recording the latest fragment.
	 */
	public static function stop()
	{
		//pop the last started fragment (nested support)
		$frag = array_pop(self::$stack);
		if($frag)
		{
			//stop 'recording' the fragment
			echo '<!-- end frache '.$frag['name'].' -->';
			//add to the array of total fragments that need to be added to Cache
			self::$fragments[] = $frag;
		}
	}

	/**
	 * Parses the output for any fragment blocks and caches them.
	 */
	public static function store()
	{
		$cache = Cache::instance();
		$html = Kohana::$output;
		foreach(self::$fragments as $frag)
		{
			$pattern = '#\<\!-- begin frache '.preg_quote($frag['name']).' --\>(.+)\<\!-- end frache '.preg_quote($frag['name']).' -->#sm';
			preg_match($pattern, $html, $matches);
			$cache->set($frag['name'], $matches[1],NULL,$frag['duration']);
		}
	}

}