<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * The modular_form helper class is for modules to add form fields to
 * forms from other modules or from the main application.
 *
 * @package		Modular_Form
 * @author		Zeelot
 *
 */
class form_module{

	/**
	 * @var <array>
	 * The array of form names and the assiociated views or form fields
	 * to appent to them
	 */
	protected static $modules = array();

	/**
	 * Sets a view to be added to a form.
	 *
	 * @param   string|array  name or array of form names to add the view to
	 * @param   mixed         the view object or string of form fields
	 * @return	void
	 */
	public static function set($name, $value = NULL)
	{
		if (is_array($name))
		{
			foreach ($name as $key => $value)
			{
				self::__set($key, $value);
			}
		}
		else
		{
			self::__set($name, $value);
		}
	}

	/**
	 * @param   string   variable key
	 * @param   string   variable value
	 * @return  void
	 */
	public static function __set($key, $value)
	{
		self::$modules[$key][] = $value;
	}

	/**
	 * Returns the array of modules that correspond to a form
	 * 
	 * @param   string   variable form
	 * @return  array
	 */
	public function get($form)
	{
		return (isset(self::$modules[$form]))? self::$modules[$form]: array();
	}
}