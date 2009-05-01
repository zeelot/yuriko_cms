<?php

class content_navigation_hook{

	public function __construct()
	{
		Event::add('admin.nav.content', array($this, 'render_nav_items'));
	}
	public function render_nav_items()
	{
		echo View::factory('admin/nav/generic_item')
			->set('item', html::anchor('admin/navigation/manage', 'Navigation Content'));
	}
}
new content_navigation_hook;