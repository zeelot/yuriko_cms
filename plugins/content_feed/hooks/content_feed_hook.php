<?php

class content_feed_hook{

	public function __construct()
	{
		Event::add('admin.nav.content', array($this, 'render_nav_items'));
		Event::add('yuriko.pages_edit_add_nodes_table', array($this, 'add_to_page_edit'));
	}
	public function render_nav_items()
	{
		echo View::factory('admin/nav/generic_item')
			->set('item', html::anchor('admin/feed/manage', 'Feeds'));
	}
	public function add_to_page_edit()
	{
		$page = Event::$data;
		$type = 'feed';
		$name = 'Feeds';
		echo View::factory('forms/add_nodes_to_page')
			->set('page', $page)
			->set('type', $type)
			->set('name', $name);
	}
}
new content_feed_hook;