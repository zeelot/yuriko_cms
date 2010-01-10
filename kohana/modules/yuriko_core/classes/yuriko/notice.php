<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Yuriko_Notice{

	//array of undisplayed noticed
	static protected $notices = array();
	//array of displayed notices (won't exist on next page load)
	static protected $history = array();

	/**
	 * Checks if a notice or group of notices exists
	 *
	 * @param String $group - the group of notices to check for
	 * @return Bool - if notices where found or not
	 */
	public static function exists($group = NULL)
	{
		if ($group === NULL)
		{
			return (bool)((sizeof(self::$notices) OR (sizeof(self::$history))));
		}
		else
		{
			return (isset(self::$notices[$group])) OR (isset(self::$history[$group]));
		}
	}

	/**
	 * Add a notice to display to the user.
	 *
	 * @param String $message
	 * @param String $group
	 * @param Array $attr - array of attributes for the notice
	 */
	public static function add($message, $group = 'default', $attr = array())
	{
		$defaults = array('class' => 'success');
		$attr = array_merge($defaults, $attr);
		$notice = array
		(
			'message' => $message,
			'attr' => $attr,
		);
		self::$notices[$group][] = $notice;
		Session::instance()->set('notices', self::$notices);
	}

	/**
	 * Renders a group of notices
	 *
	 * @param String $group - the group of notices to render
	 * @param String $template - the View to use to render the notices
	 */
	public static function render($group = NULL, $template = 'notice/render')
	{
		if ($group == NULL)
		{
			//render all the groups
			if (sizeof(self::$notices) > 0)
			{
				foreach (self::$notices as $g => $notices)
				{
					//save it incase it needs to be rendered again
					self::$history[$g] = View::factory($template)
						->set('group', $g)
						->set('notices', $notices);
					echo self::$history[$g];
				}
				//clear $notices for new ones
				self::$notices = array();
			}
			else
			{
				//display any notices that are in history
				if (sizeof(self::$history) != 0)
				{
					foreach (self::$history as $view)
					{
						//display all the views (this is a repeat render)
						echo $view;
					}
				}
			}
		}
		else
		{
			//only echo specified type (if not from $notices then from $history
			if (isset(self::$notices[$group]))
			{
				self::$history[$group] = View::factory($template)
						->set('group', $group)
						->set('notices', self::$notices[$group]);
				//remove the notice from session
				unset(self::$notices[$group]);
				echo self::$history[$group];
			}
			else
			{
				if (isset(self::$history[$group]))
				{
					echo self::$history[$group];
				}
			}
		}
		//save new undisplayed noticed to session
		Session::instance()->set('notices', self::$notices);
	}

	/**
	 * Loads all unread notices from the session
	 */
	public static function load()
	{
		self::$notices = Session::instance()->get('notices', array());
	}
}
