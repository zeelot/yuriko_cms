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

		$limit = (isset($args['limit']))? $args['limit'] : 5;

		// Load the feed from cache
		$feed = $this->cache->get('feed--'.$model->name);
		if (empty($feed))
		{
			$feed = $this->_load_feed($model->name, $model->url);
			$this->cache->set('feed--'.$model->name, $feed, array('feeds'));
		}
		$model->items = feed::parse($feed, $limit);

		echo View::factory('content/feed/'.$view)
			->set('data', $model);
	}

	/**
	 *  Taken from the kohana website branch on kohanaphp.com
	 *  THANKS!
	 */
	public function _load_feed($id, $url)
	{
		static $feeds;

		is_array($feeds) OR $feeds = array();

		// Initialize CURL
		$curl = curl_init();

		// Set CURL options
		curl_setopt_array($curl, array
		(
			CURLOPT_USERAGENT      => Kohana::$user_agent,
			CURLOPT_TIMEOUT        => 10,
			CURLOPT_CONNECTTIMEOUT => 6,
			CURLOPT_RETURNTRANSFER => TRUE,
		));

		// Change the URL
		curl_setopt($curl, CURLOPT_URL, $url);

		$feed = curl_exec($curl);

		// Close CURL
		curl_close($curl);

		if ($feed)
		{
			// Add the URL to the feeds
			$feeds[$id] = $feed;
		}
		return $feed;
	}
}