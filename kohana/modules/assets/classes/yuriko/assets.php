<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * The assets class handles loading view dependencies and simple assets.
 * 
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */
 
class Yuriko_Assets {
	
	/**
	 * Asset groups defined in config files
	 *
	 * @var array
	 */
	protected $_assets = array();

	/**
	 * Wether or not the dependencies have been calculated
	 *
	 * @var bool
	 */
	protected $_loaded_dependencies;

	/**
	 * Returns the instance of the class
	 *
	 * @staticvar Assets $instance
	 * @return Assets
	 */
	public static function instance()
	{
		static $instance;
		( ! $instance) AND $instance = new self();

		return $instance;
	}

	protected function __construct(){}

	public function render()
	{
		// calculate the dependencies just once
		( ! $this->_loaded_dependencies) AND $this->load_dependencies();

		// sort the assets
		usort($this->_assets, array($this, 'sort_assets'));

		$output = "\n";
		
		foreach ($this->_assets as $group)
		{
			$styles = Arr::get($group, 'css_files', array());
			$scripts = Arr::get($group, 'js_files', array());

			// css files
			foreach ($styles as $file => $params)
			{
				$wrapper = Arr::get($params, 'wrapper', array('', ''));
				$attributes = Arr::get($params, 'attributes', NULL);

				$output .= $wrapper[0]."\n";
				$output .= HTML::style($file, $attributes)."\n";
				$output .= $wrapper[1]."\n";
			}

			// js files
			foreach ($scripts as $file => $params)
			{
				$wrapper = Arr::get($params, 'wrapper', array('', ''));
				$attributes = Arr::get($params, 'attributes', NULL);

				$output .= $wrapper[0]."\n";
				$output .= HTML::style($file, $attributes)."\n";
				$output .= $wrapper[1]."\n";
			}
		}

		return $output;
	}

	/**
	 * Adds an asset group to the list of files to include
	 *
	 * @param String $key - config key of the asset group
	 */
	public function add_group($key)
	{
		$group = Kohana::config('assets.'.$key);

		$group AND $this->_assets[] = $group;
	}

	/**
	 * Custom sorting method for assets based on 'weight' key
	 */
	public function sort_assets($a, $b)
	{
        if ($a['weight'] == $b['weight']) {
            return 0;
        }
        return ($a['weight'] > $b['weight']) ? +1 : -1;
	}
	
	/**
	 * Calculates all the dependencies based on which views were loaded
	 * for this request. Only runs once per request (should be done at the end)
	 *
	 * @param bool $force - will reload dependencies if TRUE
	 */
	protected function load_dependencies($force = FALSE)
	{
		// run this method the first time only
		if ($this->_loaded_dependencies AND ! $force)
			return;

		// the Views that where used
		$views = (array)View::$loaded;

		// the assets that where defined
		$assets = (array)Kohana::config('assets');

		foreach ($assets as $key => $asset)
		{
			// wether or not to include this set of assets
			$pass = FALSE;

			$testing_views = $views;
			
			$exclude_views = Arr::get($asset['rules'], 'exclude_views');
			$exclude_dirs = Arr::get($asset['rules'], 'exclude_directories');
			$exclude_regex = Arr::get($asset['rules'], 'exclude_regex');

			$include_views = Arr::get($asset['rules'], 'views');
			$include_dirs = Arr::get($asset['rules'], 'directories');
			$include_regex = Arr::get($asset['rules'], 'regex');

			// @TODO: cache stuff

			// check exclude rules first
			if ($exclude_views)
			{
				// unset any views that are excluded so we don't them
				$testing_views = array_diff($testing_views, $exclude_views);
			}

			if ($exclude_regex)
			{
				// @TODO: implement
			}

			if ($exclude_dirs)
			{
				// unset any views that are in these directories
				$to_unset = array();

				foreach ($testing_views as $v)
				{
					if ($this->is_in_directories($exclude_dirs, $v))
					{
						$to_unset[] = $v;
					}
				}

				$testing_views = array_diff($testing_views, $to_unset);
			}

			// start testing inclusion rules (only need one match)
			if ($include_views)
			{
				$diff = array_diff($testing_views, $include_views);
				
				// if $diff is smaller, we had at least one match
				if (count($diff) < count($testing_views))
				{
					$this->add_group($key);

					// skip to next asset
					continue;
				}
			}

			if ($include_dirs)
			{
				if ($this->is_in_directories($include_dirs, $testing_views))
				{
					$this->add_group($key);
					
					// skip to next asset
					continue;
				}
			}

			// check regex last for performance reasons
			if ($include_regex)
			{
				// @TODO: implement
			}
		}
		$this->_loaded_dependencies = TRUE;
	}

	/**
	 * Checks if a view is in any of the given directories
	 *
	 * @param array $directories
	 * @param string $view - the view path
	 * @return bool
	 */
	public function is_in_directories(array $directories, array $views)
	{
		foreach ($directories as $dir)
		{
			foreach ($views as $view)
			{
				// check if $dir is in the path of $view
				if (strpos(dirname($view), $dir) !== FALSE)
					return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 *
	 * @param String $regex - the regex to test all the views against
	 * @param array $views - the array of view paths to test
	 * @return Bool
	 */
	public function matches_regex(array $regexes, array $views)
	{
		// @TODO: implement
		return FALSE;
	}
} // End Assets