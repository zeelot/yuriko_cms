<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Gmaps module demo controller. This controller should NOT be used in production.
 * It is for demonstration purposes only!
 *
 * $Id: gmaps_demo.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Gmaps
 * @author     Woody Gilk
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Gmaps_Demo_Controller extends Controller {

	// Do not allow to run in production
	const ALLOW_PRODUCTION = FALSE;

	public function index()
	{
		// Create a new Gmap
		$map = new Gmap('map', array
		(
			'ScrollWheelZoom' => TRUE,
		));

		// Set the map center point
		$map->center(0, 0, 1)->controls('large')->types('G_PHYSICAL_MAP', 'add');

		// Add a custom marker icon
		$map->add_icon('tinyIcon', array
		(
			'image' => 'http://labs.google.com/ridefinder/images/mm_20_red.png',
			'shadow' => 'http://labs.google.com/ridefinder/images/mm_20_shadow.png',
			'iconSize' => array('12', '20'),
			'shadowSize' => array('22', '20'),
			'iconAnchor' => array('6', '20'),
			'infoWindowAnchor' => array('5', '1')
	    ));

		// Add a new marker
		$map->add_marker(44.9801, -93.2519, '<strong>Minneapolis, MN</strong><p>Hello world!</p>', array('icon' => 'tinyIcon', 'draggable' => true, 'bouncy' => true));

		View::factory('gmaps/api_demo')->set(array('api_url' => Gmap::api_url(), 'map' => $map->render()))->render(TRUE);
	}

	public function image_map()
	{
		$points = array('-37.814251' => '144.963169', '-33.867139' => '151.207114', '-27.467580' => '153.027892');

		View::factory('gmaps/static_demo')->set(array('simple' => Gmap::static_map(44.9801, -93.2519),'multi' => Gmap::static_map($points)))->render(TRUE);
	}

	public function azmap()
	{
		// Create a new Gmap
		$map = new Gmap('map', array
		(
			'ScrollWheelZoom' => TRUE,
		));

		// Set the map center point
		$map->center(0, 35, 2)->controls('large');

		// Set marker locations
		foreach (ORM::factory('location')->find_all() as $location)
		{
			// Add a new marker
			$map->add_marker($location->lat, $location->lon,

			// Get the info window HTML
			View::factory('gmaps/info_window')->bind('location', $location)->render());
		}

		header('Content-Type: text/javascript');
		echo $map->render();
	}

	public function admin()
	{
		$valid = ! empty($_POST);

		$_POST = Validation::factory($_POST)
			->pre_filter('trim')
			->add_rules('title', 'required', 'length[4,32]')
			->add_rules('description', 'required', 'length[4,127]')
			->add_rules('link', 'length[6,127]', 'valid::url')
			->add_rules('address', 'required', 'length[4,127]')
			->add_callbacks('address', array($this, '_admin_check_address'));

		if ($_POST->validate())
		{
			// Create a new location
			$location = ORM::factory('location');

			//
			foreach ($_POST->as_array() as $key => $val)
			{
				$location->$key = $val;
			}

			echo Kohana::debug($_POST->as_array());
		}

		if ($errors = $_POST->errors())
		{
			foreach ($errors as $input => $rule)
			{
				// Add the errors
				$_POST->message($input, Kohana::lang("gmaps.form.$input"));
			}
		}

		View::factory('gmaps/admin')->render(TRUE);
	}

	public function _admin_check_address(Validation $array, $input)
	{
		if ($array[$input] == '')
			return;

		// Fetch the lat and lon via Gmap
		list ($lat, $lon) = Gmap::address_to_ll($array[$input]);

		if ($lat === NULL OR $lon === NULL)
		{
			// Add an error
			$array->add_error($input, 'address');
		}
		else
		{
			// Set the latitude and longitude
			$_POST['lat'] = $lat;
			$_POST['lon'] = $lon;
		}
	}

	public function jquery()
	{
		$map = new Gmap('map');

		$map->center(0, 35, 16)->controls('large');

		View::factory('gmaps/jquery')->set(array('api_url' => Gmap::api_url(), 'map' => $map->render('gmaps/jquery_javascript')))->render(TRUE);
	}

	public function xml()
	{
		// Get all locations
		$locations = ORM::factory('location')->find_all();

		// Create the XML container
		$xml = new SimpleXMLElement('<gmap></gmap>');

		foreach ($locations as $location)
		{
			// Create a new mark
			$node = $xml->addChild('marker');

			// Set the latitude and longitude
			$node->addAttribute('lon', sprintf('%F', $location->lon));
			$node->addAttribute('lat', sprintf('%F', $location->lat));

			$node->html = View::factory('gmaps/xml')->bind('location', $location)->render();

			foreach ($location->as_array() as $key => $val)
			{
				// Skip the ID
				if ($key === 'id') continue;

				// Add the data to the XML
				$node->$key = $val;
			}
		}

		header('Content-Type: text/xml');
		echo $xml->asXML();
	}

} // End Google Map Controller