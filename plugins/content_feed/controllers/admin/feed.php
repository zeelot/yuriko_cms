<?php
/*
 * Manage Feed Content
 */
class Feed_Controller extends Admin_Controller {

	public function manage()
	{
		$contents = ORM::factory('feed_content')->find_all();
		$this->template->content = View::factory('admin/content/feed/manage');
		$this->template->content->contents = $contents;
	}
	public function edit($id = NULL)
	{
		$content = ORM::factory('feed_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['yuriko_feed_content']))
		{
			//update the page
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();
				notice::add('Feed Saved!', 'success');
				url::redirect('admin/feed/manage');
			}
			else
			{
				$errors = $post->errors('yuriko_content_feed_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}

		$this->template->content = View::factory('admin/content/feed/form');
		$this->template->content->action = 'edit';
		$this->template->content->item = $content;
	}
	public function create()
	{
		//create a new Basic_Content object
		$content = ORM::factory('feed_content');
		if(isset($_POST['yuriko_feed_content']))
		{
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();
				notice::add('Feed Added!', 'success');
				url::redirect('admin/feed/manage');
			}
			else
			{
				$errors = $post->errors('yuriko_content_feed_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$content->load_values($_POST);
		$this->template->content = View::factory('admin/content/feed/form');
		$this->template->content->action = 'create';
		$this->template->content->item = $content;
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');
	}
	public function delete($id = NULL)
	{
		$content = ORM::factory('feed_content', $id);
		if (!$content->loaded) Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$content->delete();
			notice::add('Feed Deleted Successfully!', 'success');
			url::redirect('admin/feed/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/feed/manage');
		}
		$this->template->content = View::factory('admin/content/feed/delete');
	}
} // End Admin Feed Controller