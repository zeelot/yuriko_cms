<?php

class content_basic_hook{

	public function __construct()
	{
		Event::add('admin.nav.content', array($this, 'render_nav_items'));
	}
	public function render_nav_items()
	{
		echo View::factory('admin/nav/generic_item')
			->set('item', html::anchor('admin/basic/manage', 'Basic Content'));
	}
}
new content_basic_hook;