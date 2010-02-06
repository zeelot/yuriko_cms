<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2010 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */
 
class Controller_Yuriko_Admin_Plugin extends Controller_Template {

	public function action_list()
	{
		$this->template->content = View::factory('admin/plugin/list')
			->bind('plugins', $plugins);

		$plugins = Sprig::factory('plugin')->load(NULL, FALSE);
	}

	public function action_details()
	{
		$plugin = Sprig::factory('plugin', array
			(
				'id' => $this->request->param('id'))
			)
			->load();

		if ( ! $plugin->loaded())
		{
			notice::add(__('Invalid Plugin'), 'error');
			Request::instance()
				->redirect(Request::instance('admin')
					->uri(array('action' => 'list')));
		}
	}

} // End Yuriko Plugin Controller