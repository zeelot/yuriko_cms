<?php defined('SYSPATH') OR die('No direct access allowed.');

class Gmap_Marker_Core {

	// Marker HTML
	public $html;

	// Latitude and longitude
	public $latitude;
	public $longitude;
	
	// Marker ID
	protected static $id = 0;
	
	// Marker Options
	protected $options = array();
	protected $valid_options = array
	(
		'icon',
		'dragCrossMove',
		'title',
		'clickable',
		'draggable',
		'bouncy',
		'bounceGravity',
		'autoPan'
	);

	/**
	 * Create a new GMap marker.
	 *
	 * @param float $lat latitude
	 * @param float $lon longitude
	 * @param string $html HTML of info window
	 * @param array $options marker options
	 * @return  void
	 */
	public function __construct($lat, $lon, $html, $options = array())
	{
		if ( ! is_numeric($lat) OR ! is_numeric($lon))
			throw new Kohana_Exception('gmaps.invalid_marker', $lat, $lon);

		// Set the latitude and longitude
		$this->latitude = $lat;
		$this->longitude = $lon;

		// Set the info window HTML
		$this->html = $html;
		
		if (count($options) > 0)
		{
			foreach ($options as $option => $value) 
			{
				// Set marker options
				if (in_array($option, $this->valid_options, true))
					$this->options[] = "$option:$value";
			}
		}
	}

	public function render($tabs = 0)
	{
		// Create the tabs
		$tabs = empty($tabs) ? '' : str_repeat("\t", $tabs);

		// Marker ID
		$marker = 'm'.++self::$id;

		$output[] = 'var '.$marker.' = new google.maps.Marker(new google.maps.LatLng('.$this->latitude.', '.$this->longitude.'), {'.implode(",", $this->options).'});';
		if ($html = $this->html)
		{
			$output[] = 'google.maps.Event.addListener('.$marker.', "click", function()';
			$output[] = '{';
			$output[] = "\t".$marker.'.openInfoWindowHtml(';
			$output[] = "\t\t'".implode("'+\n\t\t$tabs'", explode("\n", $html))."'";
			$output[] = "\t);";
			$output[] = '});';
		}
		$output[] = 'map.addOverlay('.$marker.');';

		return implode("\n".$tabs, $output);
	}

} // End Gmap Marker