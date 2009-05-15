<?php
/*
 * Manage Feed Content
 */
class Feed_Controller extends Admin_Controller {

	public function manage()
	{
		$contents = ORM::factory('feed_content')->find_all();
		$this->template->content = View::factory('admin/content/feed/manage');
		$this->template->content->contents = $contents;
	}
	public function edit($id = NULL)
	{
		$content = ORM::factory('feed_content', $id);
		if (!$content->loaded)Event::run('system.404');//incorrect $id

		if(isset($_POST['yuriko_feed_content']))
		{
			//update the page
			$post = $this->input->post();
			if($content->validate($post))
			{
				$arg_rows = array();
				$passed = true;
				$arguments = $this->input->post('arguments');
				foreach ($arguments as $key => $value)
				{
					//find any existing argument with this key and node_id
					$arg = ORM::factory('content_argument')
						->where(array
							(
								'content_node_id' => $content->node_id,
								'key' => $key,
							)
						)->find();
					if ($value == '' OR empty($value)){
						//the argument was deleted in the form..delete the row
						$arg->delete();
						continue;
					}
					//build the array
					$array = array
					(
						//type is added for validation purposes
						'type' => 'feed',
						'content_node_id' => $content->node_id,
						'key' => $key,
						'value' => $value,
					);
					if (!$arg->validate($array))
					{
						//don't save the models
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
					$content->save();
					notice::add('Feed Saved!', 'success');
					url::redirect('admin/feed/manage');
				}
			}
			else
			{
				$errors = $post->errors('yuriko_content_feed_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}

		$this->template->content = View::factory('admin/content/feed/form');
		$this->template->content->action = 'edit';
		$this->template->content->item = $content;
		$this->template->content->node_arguments =
			View::factory('admin/content/nodes/feed_content_arguments')
				->set('args', arguments::get_model_args($content->node));
	}
	public function create()
	{
		//create a new Feed_Content object
		$content = ORM::factory('feed_content');
		if(isset($_POST['yuriko_feed_content']))
		{
			$post = $this->input->post();
			if($content->validate($post))
			{
				$content->save();//delete if arguments fail validation

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
						'type' => 'feed',
						'content_node_id' => $content->node_id,
						'key' => $key,
						'value' => $value,
					);
					$arg = new Content_Argument_Model;
					if (!$arg->validate($array))
					{
						//will delete the models
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
					notice::add('Feed Added!', 'success');
					url::redirect('admin/feed/manage');
				}
				else
				{
					$content->delete();
				}
			}
			else
			{
				$errors = $post->errors('yuriko_content_feed_errors');
				foreach($errors as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$content->load_values($_POST);
		$this->template->content = View::factory('admin/content/feed/form');
		$this->template->content->action = 'create';
		$this->template->content->item = $content;
		$this->template->content->node_arguments =
			View::factory('admin/content/nodes/feed_content_arguments');
	}
	public function delete($id = NULL)
	{
		$content = ORM::factory('feed_content', $id);
		if (!$content->loaded) Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$content->delete();
			notice::add('Feed Deleted Successfully!', 'success');
			url::redirect('admin/feed/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/feed/manage');
		}
		$this->template->content = View::factory('admin/content/feed/delete');
	}
} // End Admin Feed Controller