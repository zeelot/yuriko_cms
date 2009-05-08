<?php
/*
 * Output Feed Content
 */
class Content_Feed_Controller extends Controller {

	// Cache instance
	protected $cache;
	/**
	 *
	 * @param <mixed> $id The primary_key value of the Basic_Content_Model
	 * @param <string> $view the view to use to render the content
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $view = 'default', $args = NULL)
	{
		$model = ORM::factory('feed_content', $id);
		if (!$model->loaded) return FALSE;
		$this->cache = new Cache;


		// Load the feed from cache
		$feed = $this->cache->get('feed--'.$model->name);
		if (empty($feed))
		{
			// Queue the load feed for loading
			$this->_load_feed('feed--'.$model->name, $model->url);
		}
		$model->items = empty($feed) ? array() : feed::parse($this->cache->get('feed--'.$model->name), 10);

		echo View::factory('content/feed/'.$view)
			->set('data', $model);
		// Load feeds after display
		Event::add('system.shutdown', array($this, '_load_feed'));
	}

	/**
	 *  Taken from the kohana website branch on kohanaphp.com
	 *  THANKS!
	 */
	public function _load_feed($id = NULL, $url = NULL)
	{
		static $feeds;

		is_array($feeds) or $feeds = array();

		if (empty($id) AND empty($url))
		{
			// Disable error reporting
			$ER = error_reporting(0);

			// Send all current output
			while (ob_get_level() > 0) ob_end_flush();

			// Flush the buffer
			flush();

			// Initialize CURL
			$curl = curl_init();

			// Set CURL options
			curl_setopt_array($curl, array
			(
				CURLOPT_USERAGENT      => Kohana::$user_agent,
				CURLOPT_TIMEOUT        => 10,
				CURLOPT_CONNECTTIMEOUT => 6,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_MUTE           => TRUE,
			));

			foreach ($feeds as $id => $url)
			{
				// Change the URL
				curl_setopt($curl, CURLOPT_URL, $url);

				if ($feed = curl_exec($curl))
				{
					// Cache the retrieved feed
					$this->cache->set($id, $feed);
				}
			}

			// Close CURL
			curl_close($curl);

			// Restore error reporting
			error_reporting($ER);
		}
		else
		{
			// Add the URL to the feeds
			$feeds[$id] = $url;
		}
	}
}