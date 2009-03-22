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
		$pages = ORM::factory('basic_content')->find_all();
		$this->template->content = View::factory('content/static/admin/basic/manage');
		$this->template->content->pages = $pages;
	}
	public function edit($id = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['edit_basic_content']))
		{
			//update the page
			if($content->update($_POST))
			{
				$content->save();
				notice::add('Content Saved!', 'success');
				url::redirect('admin/basic/manage');
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
		$this->template->content = View::factory('content/static/admin/basic/create');
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');
	}
	public function create_node($id = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded) Event::run('system.404');
		$type = ORM::factory('content_type', 'basic');

		$node = new Content_Node_Model();
		$node->content_type_id = $type->id;
		$node->content_id = $content->id;
		$node->name = $content->name;
		$node->alias = 'basic/'.$content->name;
		$node->save();
		$content->node_id = $node->id;
		$content->save();
		notice::add('Node Created!', 'success');
		url::redirect('admin/basic/manage');
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
		$this->template->content = View::factory('content/static/admin/nodes/delete');
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
		$this->template->content = View::factory('content/static/admin/basic/delete');
	}
} // End Admin Basic Controller