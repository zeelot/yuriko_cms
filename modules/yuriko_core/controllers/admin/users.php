<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * Manage Users
 */
class Users_Controller extends Admin_Controller {

	public function manage()
	{

		$users = ORM::factory('user')->find_all();
		$this->template->content = View::factory('admin/users/manage');
		$this->template->content->users = $users;
	}
	public function create()
	{
		$user = ORM::factory('user');
		if (isset($_POST['new_user']))
		{
			$post = $this->input->post();
			$user->load_values($post);
			//create the new user
			if($user->validate($post))
			{
				$user->save();
				//make all users admins for now
				$user->add(ORM::factory('role', 'login'));
				$user->add(ORM::factory('role', 'admin'));
				$user->save();
				notice::add('User Created Successfully.', 'success');
				url::redirect('admin/users/manage');
			}
			else
			{
				foreach($post->errors('form_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}

		}
		$this->template->content = View::factory('admin/users/create');
		$this->template->content->user = $user;
	}
	public function delete($id = NULL)
	{
		$user = ORM::factory('user', $id);
		if(!$user->loaded) Event::run('system.404');
		if($user->username == 'admin') Event::run('system.404');
		if(isset($_POST['confirm']))
		{
			$user->delete();
			notice::add('User Deleted Successfully.', 'success');
			url::redirect('admin/users/manage');
		}
		elseif(isset($_POST['cancel']))
		{
			notice::add('Action Cancelled!', 'success');
			url::redirect('admin/users/manage');
		}
		$this->template->content = View::factory('admin/users/delete');
	}
	public function edit($id = NULL)
	{
		$user = ORM::factory('user', $id);
		if(!$user->loaded) Event::run('system.404');

		if (isset($_POST['edit_user']))
		{
			$post = $this->input->post();
			if($user->validate($post))
			{
				$user->save();
				notice::add('User Saved.', 'success');
				url::redirect('admin/users/manage');
			}
			else
			{
				foreach($post->errors('page_errors') as $error)
				{
					notice::add($error, 'error');
				}
			}
		}
		$this->template->content = View::factory('admin/users/edit');
		$this->template->content->user = $user;
	}

} // End Admin Users Controller