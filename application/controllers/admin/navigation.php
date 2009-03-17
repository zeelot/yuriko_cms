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
		if (isset($_POST['new_navigation_form']))
		{
			$post = $this->input->post();
			$node = ORM::factory('navigation_content');
			$parent = ORM::factory('navigation_content', $post['parent_id']);
			if ($node->validate($post))
			{
				$node->insert_as_first_child($parent);
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
		$this->template->content = View::factory('content/static/admin/navigation/manage');
		$this->template->content->root = $root;
		$this->template->content->nodes = $nodes;
	}
	public function edit($id)
	{
		
	}
	public function delete($id)
	{
		$node = ORM::factory('navigation_content', $id);
		if (!(bool)$node->id) Event::run('system.404');

		if($node->delete())
		{
			notice::add('Item Deleted Successfully!', 'success');
		}
		else
		{
			//@TODO: look into why this is always FALSE
			notice::add('Item Deleted Successfully!', 'success');
		}
		url::redirect('admin/navigation/manage');
	}
} // End Admin Navigation Controller