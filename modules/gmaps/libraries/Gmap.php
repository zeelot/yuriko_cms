<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Google Maps API integration.
 *
 * $Id: Gmap.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Gmaps
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Gmap_Core {

	/**
	 * Return GMap javascript url
	 *
	 * @param   string  API component
	 * @param   array   API parameters
	 * @return  string
	 */
	 public static function api_url($component = 'jsapi', $parameters = NULL, $separator = '&amp;')
	 {
		if (empty($parameters['ie']))
		{
			// Set input encoding to UTF-8
			$parameters['ie'] = 'utf-8';
		}

		if (empty($parameters['oe']))
		{
			// Set ouput encoding to input encoding
			$parameters['oe'] = $parameters['ie'];
		}

		if (empty($parameters['key']))
		{
			// Set the API key last
			$parameters['key'] = Kohana::config('gmaps.api_key');
		}

		return 'http://'.Kohana::config('gmaps.api_domain').'/'.$component.'?'.http_build_query($parameters, '', $separator);
	 }

	/**
	 * Retrieves the latitude and longitude of an address.
	 *
	 * @param string $address address
	 * @return array longitude, latitude
	 */
	public static function address_to_ll($address)
	{
		$lat = NULL;
		$lon = NULL;

		if ($xml = Gmap::address_to_xml($address))
		{
			// Get the latitude and longitude from the Google Maps XML
			// NOTE: the order (lon, lat) is the correct order
			list ($lon, $lat) = explode(',', $xml->Response->Placemark->Point->coordinates);
		}

		return array($lat, $lon);
	}

	/**
	 * Retrieves the XML geocode address lookup.
	 * ! Results of this method are cached for 1 day.
	 *
	 * @param string $address adress
	 * @return object SimpleXML
	 */
	public static function address_to_xml($address)
	{
		static $cache;

		// Load Cache
		if ($cache === NULL) 
		{
			$cache = Cache::instance();
		}
		
		// Address cache key
		$key = 'gmap-address-'.sha1($address);

		if ($xml = $cache->get($key))
		{
			// Return the cached XML
			return simplexml_load_string($xml);
		}
		else
		{
			// Set the XML URL
			$xml = Gmap::api_url('maps/geo', array('output' => 'xml', 'q' => $address), '&');

			// Disable error reporting while fetching the feed
			$ER = error_reporting(~E_NOTICE);

			// Load the XML
			$xml = simplexml_load_file($xml);

			if (is_object($xml) AND ($xml instanceof SimpleXMLElement) AND (int) $xml->Response->Status->code === 200)
			{
				// Cache the XML
				$cache->set($key, $xml->asXML(), array('gmaps'), 86400);
			}
			else
			{
				// Invalid XML response
				$xml = FALSE;
			}

			// Turn error reporting back on
			error_reporting($ER);
		}

		return $xml;
	}

	/**
	 * Returns an image map
	 *
	 * @param mixed $lat latitude or an array of marker points
	 * @param float $lon longitude
	 * @param integer $zoom zoom level (1-19)
	 * @param string $type map type (roadmap or mobile)
	 * @param integer $width map width
	 * @param integer $height map height
	 * @return string
	 */
	public static function static_map($lat = 0, $lon = 0, $zoom = 6, $type = NULL, $width = 300, $height = 300)
	{
		// Valid map types
		$types = array('roadmap', 'mobile');

		// Maximum width and height are 640px
		$width = min(640, abs($width));
        $height = min(640, abs($height));

		$parameters['size'] = $width.'x'.$height;

		// Minimum zoom = 0, maximum zoom = 19
		$parameters['zoom'] = max(0, min(19, abs($zoom)));

		if (in_array($type, $types))
		{
			// Set map type
			$parameters['maptype'] = $type;
		}

		if (is_array($lat))
		{
			foreach ($lat as $_lat => $_lon)
			{
				$parameters['markers'][] = $_lat.','.$_lon;
			}

			$parameters['markers'] = implode('|', $parameters['markers']);
		}
		else
		{
			$parameters['center'] = $lat.','.$lon;
		}

        return Gmap::api_url('staticmap', $parameters);
	}

	// Map settings
	protected $id;
	protected $options;
	protected $center;
	protected $control;
	protected $overview_control;
	protected $type_control = FALSE;

	// Map types
	protected $types = array();
	protected $default_types = array
	(
		'G_NORMAL_MAP','G_SATELLITE_MAP','G_HYBRID_MAP','G_PHYSICAL_MAP'
	);
	
	// Markers icons
	protected $icons = array();

	// Map markers
	protected $markers = array();

	/**
	 * Set the GMap center point.
	 *
	 * @param string $id HTML map id attribute
	 * @param array $options array of GMap constructor options
	 * @return void
	 */
	public function __construct($id = 'map', $options = NULL)
	{
		// Set map ID and options
		$this->id = $id;
		$this->options = new Gmap_Options((array) $options);
	}

	/**
	 * Set the GMap center point.
	 *
	 * @chainable
	 * @param float $lat latitude
	 * @param float $lon longitude
	 * @param integer $zoom zoom level (1-19)
	 * @param string $type default map type
	 * @return object
	 */
	public function center($lat, $lon, $zoom = 6, $type = 'G_NORMAL_MAP')
	{
		$zoom = max(0, min(19, abs($zoom)));
		$type = ($type != 'G_NORMAL_MAP' AND in_array($type, $this->default_types, true)) ? $type : 'G_NORMAL_MAP';

		// Set center location, zoom and default map type
		$this->center = array($lat, $lon, $zoom, $type);

		return $this;
	}

	/**
	 * Set the GMap controls size.
	 *
	 * @chainable
	 * @param string $size small or large
	 * @return object
	 */
	public function controls($size = NULL)
	{
		// Set the control type
		$this->control = (strtolower($size) == 'small') ? 'Small' : 'Large';

		return $this;
	}

	/**
	 * Set the GMap overview map.
	 *
	 * @chainable
	 * @param integer $width width
	 * @param integer $height height
	 * @return object
	 */
	public function overview($width = '', $height = '')
	{
		$size = (is_int($width) AND is_int($height)) ? 'new GSize('.$width.','.$height.')' : '';
		$this->overview_control = 'map.addControl(new google.maps.OverviewMapControl('.$size.'));';

		return $this;
	}

	/**
	 * Set the GMap type controls.
	 * by default renders G_NORMAL_MAP, G_SATELLITE_MAP, and G_HYBRID_MAP
	 *
	 * @chainable
	 * @param string $type map type
	 * @param string $action add or remove map type
	 * @return object
	 */
	public function types($type = NULL, $action = 'remove')
	{
		$this->type_control = TRUE;

		if ($type !== NULL AND in_array($type, $this->default_types, true))
		{
			// Set the map type and action
			$this->types[$type] = (strtolower($action) == 'remove') ? 'remove' : 'add';
		}

		return $this;
	}
	
	/**
	 * Create a custom marker icon
	 *
	 * @chainable
	 * @param string $name icon name
	 * @param array $options icon options
	 * @return object
	 */
	public function add_icon($name, array $options)
	{
	    // Add a new cusotm icon
	    $this->icons[] = new Gmap_Icon($name, $options);
	    
	    return $this;
	}

	/**
	 * Set the GMap marker point.
	 *
	 * @chainable
	 * @param float $lat latitude
	 * @param float $lon longitude
	 * @param string $html HTML for info window
	 * @param array $options marker options
	 * @return object
	 */
	public function add_marker($lat, $lon, $html = '', $options = array())
	{
		// Add a new marker
		$this->markers[] = new Gmap_Marker($lat, $lon, $html, $options);

		return $this;
	}

	/**
	 * Render the map into GMap Javascript.
	 *
	 * @param string $template template name
	 * @param array $extra extra fields passed to the template
	 * @return string
	 */
	public function render($template = 'gmaps/javascript', $extra = array())
	{
		// Latitude, longitude, zoom and default map type
		list ($lat, $lon, $zoom, $default_type) = $this->center;

		// Map
		$map = 'var map = new google.maps.Map2(document.getElementById("'.$this->id.'"));';

		// Map controls
		$controls[] = empty($this->control) ? '' : 'map.addControl(new google.maps.'.$this->control.'MapControl());';

		// Map Types
		if ($this->type_control === TRUE)
		{
			if (count($this->types) > 0)
			{
				foreach($this->types as $type => $action)
					$controls[] = 'map.'.$action.'MapType('.$type.');';
			}

			$controls[] = 'map.addControl(new google.maps.MapTypeControl());';
		}

		if ( ! empty($this->overview_control))
			$controls[] = $this->overview_control;

		// Map centering
		$center = 'map.setCenter(new google.maps.LatLng('.$lat.', '.$lon.'), '.$zoom.', '.$default_type.');';
		
		$data = array_merge($extra, array
			(
				'map' => $map,
				'options' => $this->options,
				'controls' => implode("\n", $controls),
				'center' => $center,
				'icons' => $this->icons,
				'markers' => $this->markers,
			));

		// Render the Javascript
		return View::factory($template, $data)->render();
	}

} // End Gmap