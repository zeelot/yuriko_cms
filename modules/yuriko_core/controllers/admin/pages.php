<?php defined('SYSPATH') OR die('No direct access allowed.');
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
		if (isset($_POST['yuriko_page']))
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
				foreach($post->errors('yuriko_page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}

		}
		$templates = Kohana::list_files('views/templates/page');

		$this->template->content = View::factory('admin/content/pages/form');
		$this->template->content->page = $page;
		$this->template->content->templates = $templates;
	}
	public function edit($id = FALSE)
	{
		$page = ORM::factory('content_page', $id);
		if (!$page->loaded) Event::run('system.404');

		if (isset($_POST['yuriko_page']))
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
				foreach($post->errors('yuriko_page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$templates = Kohana::list_files('views/templates/page');

		$this->template->content = View::factory('admin/content/pages/edit');
		$this->template->content->page = $page;
		$this->template->content->pivots = $page->content_pivots;
		$this->template->content->sections = Kohana::config('theme.sections');
		$this->template->content->templates = $templates;
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
				foreach($post->errors('yuriko_page_inheritance_errors') as $error)
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

		if (isset($_POST['yuriko_page_add_node']))
		{
			$post = $this->input->post();
			$pivot = ORM::factory('content_pivot');
			if ($pivot->validate($post))
			{
				//pivot is valid, validate arguments
				//we save the pivot because we need it's id in the arguments
				$pivot->save();//delete this if the arguments fail
				//hold all the args for later saving
				//because we only want to save if they all validate
				$arg_rows = array();
				$passed = true;
				$arguments = $this->input->post('arguments');
				foreach ($arguments as $key => $value)
				{
					if ($value == '' OR empty($value)) continue;
					//build the array
					$array = array
					(
						//type is added for validation purposes
						'type' => $type,
						'content_pivot_id' => $pivot->id,
						'key' => $key,
						'value' => $value,
					);
					$arg = new Content_Argument_Model;
					if (!$arg->validate($array))
					{
						//won't save the models
						$passed = false;
						foreach($array->errors() as $error)
						{
							notice::add($error, 'error');
						}
					}
					$arg_rows[] = $arg;
				}
				if ($passed)
				{
					//save everything
					foreach ($arg_rows as $row)
					{
						$row->save();
					}
					notice::add('Content Node Added Successfully', 'success');
					url::redirect('admin/pages/edit/'.$page->id);
				}
				else
				{
					$pivot->delete();
				}
			}
			else
			{
				foreach($post->errors('yuriko_pivot_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$views = Kohana::list_files('views/content/'.$type);
		$sections = Kohana::config('theme.sections');
		$items = ORM::factory($type.'_Content')->find_all();

		$this->template->content = View::factory('admin/content/pages/add_node');
		$this->template->content->node_dropdown =
			View::factory('admin/content/nodes/'.$type.'_content_dropdown')
			->set('items', $items);
		$this->template->content->node_arguments =
			View::factory('admin/content/nodes/'.$type.'_content_arguments');
		$this->template->content->page = $page;
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