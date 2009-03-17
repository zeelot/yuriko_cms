<?php
/*
 * Manage Basic Content
 */
class Basic_Controller extends Admin_Controller {
	/**
	 * List all the basic content nodes for editing
	 */
	public function manage()
	{
		if(isset($_POST['new_basic_form']))
		{
			//create a new Basic_Content object
			$content = ORM::factory('basic_content');
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();
				notice::add('Basic Content Created!', 'success');
				url::redirect('admin/basic/edit/'.$content->id);
			}
			else
			{
				$errors = $post->errors('form_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$nodes = ORM::factory('basic_content')->find_all();
		$this->template->content = View::factory('content/static/admin/basic/manage');
		$this->template->content->nodes = $nodes;
	}
	public function edit($id)
	{
		$content = ORM::factory('basic_content', $id);
		if (!(bool)$content->id)Event::run('system.404');//incorrect $id

		if(isset($_POST['edit_content']))
		{
			//update the page
			if($content->validate($_POST))
			{
				$content->save();
				notice::add('Content Saved!', 'success');
				url::redirect(Router::$current_uri);
			}
			else
			{
				$errors = $_POST->errors('form_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}

		$this->template->content = View::factory('content/static/admin/basic/edit');
		$this->template->content->item = $content;
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');

	}
} // End Admin Basic Controller