<?php
/*
 * Manage Pages
 */
class Pages_Controller extends Website_Controller {

	public $template = 'templates/static/admin/default';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}
	/**
	 * List all the basic content nodes for editing
	 */
	public function manage()
	{
		if (isset($_POST['new_page_form']))
		{
			//create the new page
			$page = Auto_Modeler::factory('content_page');
			$post = $this->input->post();
			$page->set_fields($post);
			try
			{
				$page->save();
				notice::add('Page Created Successfully', 'success');
				url::redirect(Router::$current_uri);
			}
			catch (Kohana_User_Exception $e)
			{
				foreach($page->validation->errors('form_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
			
		}
		$nodes = Auto_Modeler::factory('content_page')->fetch_all();
		$this->template->content = View::factory('content/static/admin/pages/manage');
		$this->template->content->nodes = $nodes;
	}

	public function edit($id = FALSE)
	{
		$page = Auto_Modeler::factory('content_page', (int)$id);
		if (!$page->id) Event::run('system.404');

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
			$pivot = Auto_Modeler::factory('content_pages_sections_nodes');
			//see if the exact same content already exists on this page
			$exists = (bool)$pivot->fetch_where(array
				(
					'page_id'    => $page->id,
					'section_id' => $post['section'],
					'node_id'    => $post['node'],
				))->count();
			if($exists)
			{
				//already exists
				notice::add('That content is already there!', 'notice');
			}
			else
			{
				//add the new node to the page in the right section =D
				$pivot->page_id = $page->id;
				$pivot->section_id = $post['section'];
				$pivot->node_id = $post['node'];
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


		$nodes = Auto_Modeler::factory('content_Node')->select_list('id', 'name');
		$sections = Auto_Modeler::factory('content_Section')->select_list('id', 'name');

		$this->template->content = View::factory('content/static/admin/pages/edit');
		$this->template->content->page = $page;
		$this->template->content->objects = $page->find_related('objects');
		$this->template->content->nodes = $nodes;
		$this->template->content->sections = $sections;
	}

} // End Admin Page Controller