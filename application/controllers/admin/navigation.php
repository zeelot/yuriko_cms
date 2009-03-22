<?php
/*
 * Manage Navigation Content
 */
class Navigation_Controller extends Admin_Controller {
	
	/**
	 * List all the navigation content nodes for editing
	 */
	public function manage()
	{
		$root = ORM::factory('navigation_content')->root->find();
		$this->template->content = View::factory('content/static/admin/navigation/manage');
		$this->template->content->root = $root;
	}
	public function create()
	{
		if (isset($_POST['new_navigation_content']))
		{
			$post = $this->input->post();
			$node = ORM::factory('navigation_content');
			$parent = ORM::factory('navigation_content', $post['parent_id']);

			if ($node->validate($post))
			{
				$node->insert_as_last_child($parent);
				notice::add('Navigation Item Created!', 'success');
				url::redirect('admin/navigation/manage');
			}
			else
			{
				foreach($post->errors() as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$root = ORM::factory('navigation_content')->root->find();
		$nodes = ORM::factory('navigation_content')->orderby('lft', 'ASC')->find_all();
		$this->template->content = View::factory('content/static/admin/navigation/create');
		$this->template->content->nodes = $nodes;
		$this->template->content->pages = ORM::factory('content_page')
												->select_list('id', 'alias');
	}
	public function edit($id = NULL)
	{
		$content = ORM::factory('navigation_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['edit_navigation_content']))
		{
			$post = $this->input->post();
			//update the page
			if($content->update($post))
			{
				notice::add('Item Saved!', 'success');
				url::redirect('admin/navigation/manage');
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

		$this->template->content = View::factory('content/static/admin/navigation/edit');
		$this->template->content->item = $content;
		$this->template->content->pages = ORM::factory('content_page')
												->select_list('id', 'alias');
	}
	public function move_up($id = NULL)
	{
		$item = ORM::factory('navigation_content', $id);
		if(!$item->loaded) Event::run('system.404');

		$item->move_up();
		notice::add('Item Moved!', 'success');
		url::redirect('admin/navigation/manage');
	}
	public function move_down($id = NULL)
	{
		$item = ORM::factory('navigation_content', $id);
		if(!$item->loaded) Event::run('system.404');

		$item->move_down();
		notice::add('Item Moved!', 'success');
		url::redirect('admin/navigation/manage');
	}
	public function create_node($id = NULL)
	{
		$content = ORM::factory('navigation_content', $id);
		if (!$content->loaded) Event::run('system.404');
		$type = ORM::factory('content_type', 'navigation');

		$node = new Content_Node_Model();
		$node->content_type_id = $type->id;
		$node->content_id = $content->id;
		$node->name = $content->name;
		$node->alias = 'navigation/'.$content->tag;
		$node->save();
		$content->node_id = $node->id;
		$content->save();
		notice::add('Node Created!', 'success');
		url::redirect('admin/navigation/manage');
	}
	public function delete_node($id = NULL)
	{
		$content = ORM::factory('navigation_content', $id);
		if (!$content->loaded) Event::run('system.404');
		$node = ORM::factory('content_node', $content->node_id);
		
		if(isset($_POST['confirm']))
		{
			$content->node_id = 0;
			$content->save();
			$node->delete();
			notice::add('Node Deleted Successfully!', 'success');
			url::redirect('admin/navigation/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/navigation/manage');
		}
		$this->template->content = View::factory('content/static/admin/nodes/delete');
	}
	public function delete($id = NULL)
	{
		$item = ORM::factory('navigation_content', $id);
		if (!$item->loaded) Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$item->delete();
			notice::add('Item Deleted Successfully!', 'success');
			url::redirect('admin/navigation/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/navigation/manage');
		}
		$this->template->content = View::factory('content/static/admin/navigation/delete');
	}
} // End Admin Navigation Controller