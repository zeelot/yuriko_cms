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
		$contents = ORM::factory('basic_content')->find_all();
		$this->template->content = View::factory('admin/content/basic/manage');
		$this->template->content->contents = $contents;
	}
	public function edit($id = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['edit_basic_content']))
		{
			//update the page
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();
				notice::add('Content Saved!', 'success');
				url::redirect('admin/basic/manage');
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

		$this->template->content = View::factory('admin/content/basic/edit');
		$this->template->content->item = $content;
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');

	}
	public function create()
	{
		if(isset($_POST['create_basic_content']))
		{
			//create a new Basic_Content object
			$content = ORM::factory('basic_content');
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();
				notice::add('Basic Content Created!', 'success');
				url::redirect('admin/basic/manage');
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
		$this->template->content = View::factory('admin/content/basic/create');
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');
	}
	public function delete_node($id = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded) Event::run('system.404');
		$node = ORM::factory('content_node', $content->node_id);

		if(isset($_POST['confirm']))
		{
			$content->node_id = 0;
			$content->save();
			$node->delete();
			notice::add('Node Deleted Successfully!', 'success');
			url::redirect('admin/basic/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/basic/manage');
		}
		$this->template->content = View::factory('admin/content/nodes/delete');
	}
	public function delete($id = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded) Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$content->delete();
			notice::add('Basic Content Item Deleted Successfully!', 'success');
			url::redirect('admin/basic/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/basic/manage');
		}
		$this->template->content = View::factory('admin/content/basic/delete');
	}
} // End Admin Basic Controller