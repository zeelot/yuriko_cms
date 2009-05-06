<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * Controller to edit application settings
 */

class Settings_Controller extends Admin_Controller {

	/**
	 * List all the basic content nodes for editing
	 */
	public function manage()
	{
		if(isset($_POST['site_settings']))
		{
			//remove the hidden fields and set the other settings
			unset($_POST['site_settings']);
			unset($_POST['save']);
			$post = $this->input->post();
			foreach ($post as $key => $value)
			{
				$setting = ORM::factory('site_setting', $key);
				$array = array('key' => $key, 'value' => $value);
				$all_saved = TRUE;
				if($setting->validate($array))
				{
					$setting->save();
				}
				else
				{
					//figure out how to do errors here
				}
			}
			Event::run('site_settings.form_processing', $post);
			if($all_saved)
			{
				notice::add('Settings Saved.', 'success');
			}
			url::redirect('admin/settings/manage');
		}
		$settings = array();
		foreach (ORM::factory('site_setting')->find_all() as $setting)
		{
			$settings[$setting->key] = $setting->value;
		}
		$this->template->content = View::factory('admin/settings/manage');
		$this->template->content->settings = $settings;
	}

} // End Admin Settings Controller