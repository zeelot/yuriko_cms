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
		$this->template->content = View::factory('admin/content/navigation/manage');
		$this->template->content->root = $root;
	}
	public function create()
	{
		$item = ORM::factory('navigation_content');
		if (isset($_POST['yuriko_navigation_content']))
		{
			$post = $this->input->post();
			$parent = ORM::factory('navigation_content', $post['parent_id']);

			if ($item->validate($post))
			{
				$item->insert_as_last_child($parent);
				$item->save();
				notice::add('Navigation Item Created!', 'success');
				url::redirect('admin/navigation/manage');
			}
			else
			{
				foreach($post->errors('yuriko_content_navigation_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$item->load_values($_POST);
		$items = ORM::factory('navigation_content')->orderby('lft', 'ASC')->find_all();

		$this->template->content = View::factory('admin/content/navigation/form');
		$this->template->content->items = $items;
		$this->template->content->item = $item;
		$this->template->content->pages = ORM::factory('content_page')
												->select_list('id', 'alias');
	}
	public function edit($id = NULL)
	{
		$item = ORM::factory('navigation_content', $id);
		if (!$item->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['yuriko_navigation_content']))
		{
			$post = $this->input->post();
			//update the page
			if($item->validate($post))
			{
				$item->save();
				//if parent changed, we need to move the menu
				if ($item->parent->id != (INT)$post->parent_id)
				{
					$item->move_to_last_child(ORM::factory('navigation_content', $post->parent_id));
					$item->save();
				}
				notice::add('Item Saved!', 'success');
				url::redirect('admin/navigation/manage');
			}
			else
			{
				$errors = $post->errors('yuriko_content_navigation_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$items = ORM::factory('navigation_content')
		//remove $item from $items
		->where('id !=', $item->id)
		->orderby('lft', 'ASC')->find_all();

		$this->template->content = View::factory('admin/content/navigation/form');
		$this->template->content->items = $items;
		$this->template->content->item = $item;
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
		$this->template->content = View::factory('admin/content/navigation/delete');
	}
} // End Admin Navigation Controller