<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * GMaps Icon library.
 *
 * $Id$
 *
 * @package	   Gmaps
 * @author	   Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license	   http://kohanaphp.com/license.html
 */
class Gmap_Icon_Core {

	// Valid options
	protected $valid_options = array
	(
		'image',
		'shadow',
		'iconSize',
		'shadowSize',
		'iconAnchor',
		'infoWindowAnchor',
		'printImage',
		'mozPrintImage',
		'printShadow',
		'transparent',
		'imageMap',
		'maxHeight',
		'dragCrossImage',
		'dragCrossSize',
		'dragCrossAnchor'
	);

	// Settable options
	protected $options = array();
	
	// Icon name
	protected $name;

	/**
	 * Create a new GMap icon
	 *
	 * @param string $name icon name
	 * @param array $options GMap2 icon options
	 * @return	void
	 */
	public function __construct($name, array $options)
	{
		// set icon name
		$this->name = $name;

		foreach ($options as $key => $value)
		{
			if (in_array($key, $this->valid_options, true))
			{
				// Set all valid methods
				switch($key) 
				{
					case 'image':
					case 'shadow':
					case 'printImage':
					case 'mozPrintImage':
					case 'printShadow':
					case 'transparent':
					case 'dragCrossImage':
						$this->set_url($key, $value);
					break;
					case 'iconAnchor':
					case 'infoWindowAnchor':
					case 'infoShadowAnchor':
					case 'dragCrossAnchor':
						$this->set_point($key, $value);
					break;
					case 'iconSize':
					case 'shadowSize':
					case 'dragCrossSize':
						$this->set_size($key, $value);
					break;
					default:
						$this->options[$key] = json_encode($value);
					break;
				}
			}
		}
	}
	
	public function set_url($key, $url)
	{
		$this->options[$key] = (valid::url($url)) ? '"'.$url.'";' : '"'.url::site($url).'";';
	}
	
	public function set_size($key, $val)
	{
		$this->options[$key] = 'new google.maps.Size('.implode(',', $val).');';
	}
	
	public function set_point($key, $val)
	{
		$this->options[$key] = 'new google.maps.Point('.implode(',', $val).');';
	}

	public function render($tabs = 0)
	{
		// Create the tabs
		$tabs = empty($tabs) ? '' : str_repeat("\t", $tabs);

		$output = array();
		
		// Render each option
		$output[] = "var $this->name = ".((count($this->options) > 1) ? 'new google.maps.Icon();' : 'new google.maps.Icon(G_DEFAULT_ICON);');

		foreach($this->options as $option => $value)
		{
			$output[] = "$this->name.$option = $value";
		}

		return implode("\n".$tabs, $output);
	}

} // End Gmap Icon