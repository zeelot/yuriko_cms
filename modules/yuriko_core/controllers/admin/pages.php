<?php
/*
 * Manage Pages
 */
class Pages_Controller extends Admin_Controller {

	/**
	 * List all the basic content nodes for editing
	 */
	public function manage()
	{
		
		$pages = ORM::factory('content_page')->find_all();
		$this->template->content = View::factory('admin/content/pages/manage');
		$this->template->content->pages = $pages;
	}
	public function create()
	{
		$page = ORM::factory('content_page');
		if (isset($_POST['new_page_content']))
		{
			$post = $this->input->post();
			//simple way to repopulate form...I hope it works
			$page->load_values($post);
			//create the new page
			if($page->validate($post))
			{
				$page->save();
				notice::add('Page Created Successfully', 'success');
				url::redirect('admin/pages/manage');
			}
			else
			{
				foreach($post->errors('form_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}

		}
		$this->template->content = View::factory('admin/content/pages/create');
		$this->template->content->page = $page;
	}
	public function delete($id = NULL)
	{
		$page = ORM::factory('content_page', $id);
		if (!$page->loaded) Event::run('system.404');

		if(isset($_POST['confirm']))
		{
			$page->delete();
			notice::add('Page Deleted Successfully!', 'success');
			url::redirect('admin/pages/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/pages/manage');
		}
		$this->template->content = View::factory('admin/content/pages/delete');
	}
	public function edit($id = FALSE)
	{
		$page = ORM::factory('content_page', $id);
		if (!$page->loaded) Event::run('system.404');

		if (isset($_POST['edit_content_page']))
		{
			$post = $this->input->post();
			$page->name = $post['name'];
			$page->alias = $post['alias'];
			if($page->validate($post))
			{
				$page->save();
				notice::add('Page Saved', 'success');
				url::redirect(Router::$current_uri);
			}
			else
			{
				foreach($post->errors('page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$this->template->content = View::factory('admin/content/pages/edit');
		$this->template->content->page = $page;
		$this->template->content->pivots = $page->content_pivots;
		$this->template->content->sections = Kohana::config('theme.sections');
	}
	public function add_inheritance($id = NULL)
	{
		$page = ORM::factory('content_page', $id);
		if(!$page->loaded) Event::run('system.404');
		if (isset($_POST['page_add_inheritance']))
		{
			$post = $this->input->post();
			if($page->add_inheritance($post))
			{
				notice::add('Page Saved', 'success');
				url::redirect('admin/pages/edit/'.$page->id);
			}
			else
			{
				foreach($post->errors('page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$pages = ORM::factory('content_page')->where('id !=', $page->id)->find_all();
		$this->template->content = View::factory('admin/content/pages/add_inheritance');
		$this->template->content->pages = $pages;
	}
	public function remove_inheritance($id = NULL)
	{
		$inheritance = ORM::factory('content_page_inheritance', $id);
		if (!$inheritance->loaded) Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$page = $inheritance->content_page_id;
			$inheritance->delete();
			notice::add('Inherited Page Removed.', 'success');
			url::redirect('admin/pages/edit/'.$page);
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/pages/edit/'.$inheritance->content_page_id);
		}
		$this->template->content = View::factory('admin/content/pages/remove_inheritance');
	}
	public function add_node()
	{
		$id = URI::segment('page', NULL);
		$type = URI::segment('type', NULL);
		$page = ORM::factory('content_page', $id);

		if(!$page->loaded) Event::run('system.404');

		if (isset($_POST['page_add_content_node']))
		{
			$post = $this->input->post();
			$pivot = ORM::factory('content_pivot');
			//see if the exact same content already exists on this page
			$exists = $pivot->where(array
				(
					'content_page_id'    => $page->id,
					'content_node_id'    => $post['node'],
					'section' => $post['section'],
				))->find();
			if($exists->loaded)
			{
				//already exists
				notice::add('That content is already there!', 'notice');
			}
			else
			{
				//add the new node to the page in the right section =D
				$pivot->content_page_id = $page->id;
				$pivot->content_node_id = $post['node'];
				$pivot->section = $post['section'];
				//@TODO: fix this for in-model validation! callbacks n such
				if($pivot->save())
				{
					notice::add('Content Node Added Successfully', 'success');
					url::redirect('admin/pages/edit/'.$page->id);
				}
				else
				{
					notice::add('Error adding content!', 'error');
				}
			}
		}
		$views = Kohana::list_files('views/templates/page');
		$sections = Kohana::config('theme.sections');
		$items = ORM::factory($type.'_Content')->find_all();

		$this->template->content = View::factory('admin/content/pages/add_node');
		$this->template->content->node_dropdown = View::factory('admin/content/nodes/'.$type.'_content_dropdown')
			->set('items', $items);
		$this->template->content->sections = $sections;
		$this->template->content->views = $views;
	}
	public function remove_node($id)
	{
		$pivot = ORM::factory('content_pivot', $id);
		if (!$pivot->loaded) Event::run('system.404');
		
		if(isset($_POST['confirm']))
		{
			$page = $pivot->content_page_id;
			$pivot->delete();
			notice::add('Node Removed!', 'success');
			url::redirect('admin/pages/edit/'.$page);
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/pages/edit/'.$pivot->content_page_id);
		}
		$this->template->content = View::factory('admin/content/pages/remove_node');
	}

} // End Admin Page Controller