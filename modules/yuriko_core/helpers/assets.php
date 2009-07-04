<?php defined('SYSPATH') OR die('No direct access allowed.');

class assets_Core
{
	static protected $scripts = array();
	static protected $stylesheets = array();
	static protected $loaded_dependencies = FALSE;

	/**
	 * Defines a group of css files so views can depend on it.
	 *
	 * @param string $name - the name of the group
	 * @param array $files - the files in this group
	 * @param mixed $options - nothing yet
	 */
	public static function define_css_group($name, array $files, $options = NULL)
	{
		$current = (array)Kohana::config('assets.groups.css.'.$name);
		Kohana::config_set('assets.groups.css.'.$name,
			array_merge($current, $files));
	}
	/**
	 * Defines a group of js files so views can depend on it.
	 *
	 * @param string $name - the name of the group
	 * @param array $files - the files in this group
	 * @param mixed $options - nothing yet
	 */
	public static function define_js_group($name, array $files, $options = NULL)
	{
		$current = (array)Kohana::config('assets.groups.js'.$name);
		Kohana::config_set('assets.groups.js.'.$name,
			array_merge($current, $files));
	}
	/**
	 * Defines a dependency for a set of views so that any time the
	 * particular view is used, the assets helper knows that it requires
	 * certain css files to be loaded as well.
	 *
	 * @param array $views - the views to define dependencies for
	 * @param array $groups - the css groups that these views depend on
	 */
	public static function define_css_dependency(array $views, array $groups)
	{
		foreach ($views as $view)
		{
			$current = (array)Kohana::config('assets.dependencies.css.'.$view);
			Kohana::config_set('assets.dependencies.css.'.$view,
				array_merge($current, $groups));
		}
	}
	/**
	 * Same as define_css_dependency but for js files
	 *
	 * @param array $views - the views to define dependencies for
	 * @param array $groups - the js groups that these views depend on
	 */
	public static function define_js_dependency(array $views, array $groups)
	{
		foreach ($views as $view)
		{
			$current = (array)Kohana::config('assets.dependencies.js.'.$view);
			Kohana::config_set('assets.dependencies.js.'.$view,
				array_merge($current, $groups));
		}
	}
	/**
	 * Adds a css file to the array of files to include for this request.
	 *
	 * @param string $file - the css file
	 */
	public static function add_stylesheet($file)
	{
		if (!in_array($file, self::$stylesheets))
			self::$stylesheets[] = $file;
	}
	/**
	 * Adds a js file to the array of files to include for this request.
	 *
	 * @param string $file - the js file
	 */
	public static function add_script($file)
	{
		if (!in_array($file, self::$scripts))
			self::$scripts[] = $file;
	}
	/**
	 * Generated the html for the page header to include all the css files.
	 *
	 * @return string - the html to include in the page haeder
	 */
	static public function stylesheets()
	{
		$output = '';
		foreach (self::$stylesheets as $stylesheet)
		{
			$output .= '	'.html::stylesheet($stylesheet);
		}
		return $output;
	}
	/**
	 * Generated the html for the page header to include all the js files.
	 *
	 * @return string - the html to include in the page haeder
	 */
	static public function scripts()
	{
		$output = '';
		foreach (self::$scripts as $script)
		{
			$output .= '	'.html::script($script);
		}
		return $output;
	}
	/**
	 * Calculates all the dependencies and returns the html for both css and js.
	 *
	 * @return string - the html to include in the page header
	 */
	public static function all()
	{
		self::load_dependencies();
		return self::stylesheets().self::scripts();
	}
	/**
	 * Adds a css group to the array of css files to include for this request
	 *
	 * @param string $name - name of group
	 */
	public static function enable_css_group($name)
	{
		$files = (array)Kohana::config('assets.groups.css.'.$name);
		foreach ($files as $file)
		{
			self::add_stylesheet($file);
		}
	}
	/**
	 * Adds a js group to the array of css files to include for this request
	 *
	 * @param string $name - name of group
	 */
	public static function enable_js_group($name)
	{
		$files = (array)Kohana::config('assets.groups.js.'.$name);
		foreach ($files as $file)
		{
			self::add_script($file);
		}
	}
	/**
	 * Calculates all the dependencies based on which views were loaded
	 * for this request. Only runs once per request (should be done at the end)
	 * Called automatically by assets::all()
	 */
	public static function load_dependencies()
	{
		if (!self::$loaded_dependencies)
		{
			foreach(View::$loaded as $view)
			{
				$required_css = (array)Kohana::config('assets.dependencies.css.'.$view);
				foreach ($required_css as $group)
				{
					self::enable_css_group($group);
				}
				$required_js = (array)Kohana::config('assets.dependencies.js.'.$view);
				foreach ($required_js as $group)
				{
					self::enable_js_group($group);
				}
				self::$loaded_dependencies = TRUE;
			}
		}
	}
} // End assets_Core