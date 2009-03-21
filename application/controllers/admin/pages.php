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
		if (isset($_POST['new_page_content']))
		{
			//create the new page
			$page = ORM::factory('content_page');
			$post = $this->input->post();
			if($page->validate())
			{
				$page->save();
				notice::add('Page Created Successfully', 'success');
				url::redirect(Router::$current_uri);
			}
			else
			{
				foreach($post->errors('form_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
			
		}
		$nodes = ORM::factory('content_page')->find_all();
		$this->template->content = View::factory('content/static/admin/pages/manage');
		$this->template->content->nodes = $nodes;
	}

	public function edit($id = FALSE)
	{
		$page = ORM::factory('content_page', $id);
		if (!$page->loaded) Event::run('system.404');

		if (isset($_POST['page_info_form']))
		{
			$post = $this->input->post();
			$page->title = $post['title'];
			$page->alias = $post['alias'];
			try
			{
				$page->save();
				notice::add('Page Saved', 'success');
				url::redirect(Router::$current_uri);
			}
			catch (Kohana_User_Exception $e)
			{
				foreach($page->validation->errors('page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		if (isset($_POST['page_add_node_form']))
		{
			$post = $this->input->post();
			$pivot = ORM::factory('content_pages_sections_nodes');
			//see if the exact same content already exists on this page
			$exists = $pivot->where(array
				(
					'content_page_id'    => $page->id,
					'content_section_id' => $post['section'],
					'content_node_id'    => $post['node'],
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
				$pivot->content_section_id = $post['section'];
				$pivot->content_node_id = $post['node'];
				$pivot->save();
				try
				{
					$pivot->save();
					notice::add('Content added Successfully', 'success');
					url::redirect(Router::$current_uri);
				}
				catch (Kohana_User_Exception $e)
				{
					foreach($pivot->validation->errors('page_errors') as $error)
					{
						notice::add($error, 'error');
					}
				}
			}
		}


		$nodes = ORM::factory('content_node')->select_list('id', 'name');
		$sections = ORM::factory('content_section')->select_list('id', 'name');

		$this->template->content = View::factory('content/static/admin/pages/edit');
		$this->template->content->page = $page;
		$this->template->content->objects = $page->content_pages_sections_nodes;
		$this->template->content->nodes = $nodes;
		$this->template->content->sections = $sections;
	}

	public function remove_node($id)
	{
		$pivot = ORM::factory('content_pages_sections_nodes', $id);
		if ($pivot->loaded)
		{
			$page = $pivot->content_page_id;
			$pivot->delete();
			notice::add('Node Removed!', 'success');
			url::redirect('admin/pages/edit/'.$page);
		}
		else
		{
			Event::run('system.404');
		}
	}

} // End Admin Page Controller