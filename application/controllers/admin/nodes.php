<?php
/*
 * Manage Pages
 */
class Nodes_Controller extends Website_Controller {

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
		$nodes = Auto_Modeler::factory('content_node')->fetch_all();
		/**
		 * @TODO: Abstract this process for all content types
		 */
		$navigations = ORM::factory('navigation_content')->root->subtree(TRUE)->find_all();
		$basics = ORM::factory('basic_content')->find_all();

		$this->template->content = View::factory('content/static/admin/nodes/manage');
		$this->template->content->nodes = $nodes;
		$this->template->content->navs = $navigations;
		$this->template->content->basics = $basics;
	}

	public function attach($type, $id)
	{
		$content = ORM::factory($type.'_content', $id);
		if (!(bool)$content->id) Event::run('system.404');
		
		if (isset($_POST['new_node_form']))
		{
			//create the new page
			$node = Auto_Modeler::factory('content_node');
			$post = $this->input->post();
			$content_type = Auto_Modeler::factory('content_type', $post['content_type']);
			if (!$content_type->id)
			{
				//incorrect type
			}
			$node->content_type_id = $content_type->id;
			$node->content_id = $content->id;
			$node->name = $post['name'];
			$node->alias = $post['alias'];
			try
			{
				$node->save();
				$content->node_id = $node->id;
				$content->save();
				notice::add('Node Created Successfully', 'success');
				url::redirect('admin/nodes/manage');//back to the list of content
			}
			catch (Kohana_User_Exception $e)
			{
				foreach($node->validation->errors('node_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}

		}
		

		$this->template->content = View::factory('content/static/admin/nodes/attach');
		$this->template->content->content = $content;
		$this->template->content->type = $type;
		$this->template->content->id = $id;
	}

	public function edit($id = FALSE)
	{

	}

} // End Admin Page Controller