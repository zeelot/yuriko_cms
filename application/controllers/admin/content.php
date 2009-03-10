<?php
/*
 * Manage Basic Content
 */
class Content_Controller extends Website_Controller {

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
		$nodes = ORM::factory('basic_content')->find_all();
		$this->template->content = View::factory('content/admin/content/manage');
		$this->template->content->nodes = $nodes;

		
	}
	public function edit($id)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['edit_content']))
		{
			//update the page
			if($content->validate($_POST))
			{
				$content->save();
				notice::add('Content Saved!', 'success');
				url::redirect(Router::$current_uri);
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

		$this->template->content = View::factory('content/admin/content/edit');
		$this->template->content->item = $content;
		$this->template->content->formats = ORM::factory('content_format')
												->select_list('id', 'name');

	}

	public function pages()
	{

	}

} // End Admin Content Controller